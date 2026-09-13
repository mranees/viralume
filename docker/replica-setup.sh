#!/bin/bash
set -e

# ننتظر شوية لحد ما الـ Primary والـ Replica يكونوا جاهزين تمامًا
sleep 15

# 1. إنشاء مستخدم الـ Replication على الـ Primary (لو مش موجود بالفعل)
mysql -h mysql-primary -uroot -psecret -e "
CREATE USER IF NOT EXISTS 'replicator'@'%' IDENTIFIED BY 'replicator_pass';
GRANT REPLICATION SLAVE ON *.* TO 'replicator'@'%';
FLUSH PRIVILEGES;
"

# 2. إيقاف أي replication threads شغالة من محاولة سابقة، ثم مسح أي إعدادات قديمة
mysql -h mysql-replica -uroot -psecret -e "
STOP REPLICA;
RESET REPLICA ALL;
"

# 3. ربط الـ Replica بالـ Primary من جديد بشكل نظيف
mysql -h mysql-replica -uroot -psecret -e "
CHANGE REPLICATION SOURCE TO
  SOURCE_HOST='mysql-primary',
  SOURCE_USER='replicator',
  SOURCE_PASSWORD='replicator_pass',
  SOURCE_AUTO_POSITION=1,
  GET_SOURCE_PUBLIC_KEY=1;
START REPLICA;
"

echo "✅ Replication configured successfully"
