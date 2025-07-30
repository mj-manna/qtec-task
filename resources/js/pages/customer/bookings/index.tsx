import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bookings',
        href: '/bookings',
    },
];

export default function CustomerBookingsIndex({ bookings }: { bookings: any }) {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="container max-w-5xl mx-auto mt-5">
                <div className="sm:flex sm:items-center">
                    <div className="sm:flex-auto">
                        <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">My Bookings</h1>
                        <p className="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            View all your service bookings.
                        </p>
                    </div>
                </div>
                <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {bookings.map((booking: any) => (
                        <div key={booking.id} className="bg-white dark:bg-gray-900 overflow-hidden shadow rounded-lg">
                            <div className="p-6">
                                <div className="flex items-center">
                                    <div className="flex-shrink-0">
                                        <div className="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                                            <span className="text-white font-medium text-sm">
                                                {booking.service.name.charAt(0)}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="ml-4 flex-1">
                                        <h3 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {booking.service.name}
                                        </h3>
                                        <p className="text-sm text-gray-500 dark:text-gray-300">
                                            ${booking.service.price}
                                        </p>
                                    </div>
                                </div>

                                <div className="mt-4">
                                    <div className="flex justify-between items-center mb-2">
                                        <span className="text-sm text-gray-500 dark:text-gray-300">Booking Date:</span>
                                        <span className="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {new Date(booking.booking_date).toLocaleDateString()}
                                        </span>
                                    </div>

                                    <div className="flex justify-between items-center mb-2">
                                        <span className="text-sm text-gray-500 dark:text-gray-300">Status:</span>
                                        <span className={`px-2 py-1 rounded text-xs font-medium ${booking.status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                                                : booking.status === 'confirmed'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                            }`}>
                                            {booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                                        </span>
                                    </div>

                                    <div className="flex justify-between items-center">
                                        <span className="text-sm text-gray-500 dark:text-gray-300">Booked:</span>
                                        <span className="text-sm text-gray-900 dark:text-gray-100">
                                            {new Date(booking.created_at).toLocaleDateString()}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {bookings.length === 0 && (
                    <div className="text-center py-12">
                        <div className="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v1l-1 9a2 2 0 01-2 2H6a2 2 0 01-2-2l-1-9V9a2 2 0 012-2h3z" />
                            </svg>
                        </div>
                        <h3 className="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No bookings</h3>
                        <p className="mt-1 text-sm text-gray-500 dark:text-gray-300">
                            You haven't made any bookings yet.
                        </p>
                        <div className="mt-6">
                            <Link
                                href="/bookings/create"
                                className="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800"
                            >
                                Book a Service
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}