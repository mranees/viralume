export type Patient = {
    id: number;
    name: string;
    email: string;
    phone: string;
    address: string;
};

export type FollowUp = {
    id: number;
    doctor: string;
    date: Date;
    time: Date;
    notes: string;
};
