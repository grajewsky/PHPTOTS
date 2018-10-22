 import { User } from './User';

export interface Admin extends User {
	role?: string;
	user: User;
	name: string;
	age: number;
	
} 