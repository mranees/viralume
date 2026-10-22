import { Specialization } from './specialization';

export type Doctor = {
    id: number;
    name: string;
    email: string;
    phone: string;
    address: string;
    bio: string | null;
    vizita_price: number;
    profile_image: string | null;
    is_active: boolean;
    specializations: Specialization[];
};
