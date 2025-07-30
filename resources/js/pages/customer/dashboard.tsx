import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function CustomerDashboard({ services, bookings }: { services: any, bookings: any }) {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="container max-w-5xl mx-auto mt-5">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Welcome to Service Booking</h1>
                    <p className="text-gray-600 dark:text-gray-300">Book your favorite services and manage your bookings.</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div className="bg-white dark:bg-gray-900 overflow-hidden shadow rounded-lg">
                        <div className="px-4 py-5 sm:p-6">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    Available Services
                                </h3>
                                <Link
                                    href="/bookings/create"
                                    className="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800"
                                >
                                    Book Now
                                </Link>
                            </div>
                            <div className="space-y-4">
                                {services.map((service: any) => (
                                    <div
                                        key={service.id}
                                        className="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800"
                                    >
                                        <h4 className="text-lg font-semibold text-gray-900 dark:text-gray-100">{service.name}</h4>
                                        <p className="text-gray-600 dark:text-gray-300 text-sm mb-2">{service.description}</p>
                                        <div className="flex justify-between items-center">
                                            <span className="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                BDT {service.price}
                                            </span>
                                            <span
                                                className={`px-2 py-1 rounded text-xs ${service.status === 'active'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                                    }`}
                                            >
                                                {service.status}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                    <div className="bg-white dark:bg-gray-900 overflow-hidden shadow rounded-lg">
                        <div className="px-4 py-5 sm:p-6">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                    Recent Bookings
                                </h3>
                                <Link
                                    href="/bookings"
                                    className="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm"
                                >
                                    View All
                                </Link>
                            </div>
                            <div className="space-y-4">
                                {bookings.slice(0, 3).map((booking: any) => (
                                    <div key={booking.id} className="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                                        <h4 className="font-semibold text-gray-900 dark:text-gray-100">{booking.service.name}</h4>
                                        <p className="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                            Date: {new Date(booking.booking_date).toLocaleDateString()}
                                        </p>
                                        <span className={`px-2 py-1 rounded text-xs ${
                                            booking.status === 'pending' 
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                                                : booking.status === 'confirmed'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                        }`}>
                                            {booking.status}
                                        </span>
                                    </div>
                                ))}
                                {bookings.length === 0 && (
                                    <p className="text-gray-500 dark:text-gray-400 text-center py-4">
                                        No bookings yet. <Link href="/bookings/create" className="text-indigo-600 dark:text-indigo-400">Book your first service!</Link>
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
