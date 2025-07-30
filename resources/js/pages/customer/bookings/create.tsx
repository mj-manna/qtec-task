import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, Link, useForm } from "@inertiajs/react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Bookings',
        href: '/bookings',
    },
];
export default function CustomerBookingsCreate({ services }: { services: any }) {
    const { data, setData, post, processing, errors } = useForm({
        service_id: '',
        booking_date: '',
    })

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        post('/bookings')
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="container max-w-5xl mx-auto mt-5">
                <div className="max-w-2xl mx-auto">
                    <div className="mb-8">
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Book a Service</h1>
                        <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Choose a service and select your preferred date.
                        </p>
                    </div>
                </div>
                <form onSubmit={submit} className="space-y-6">
                    <div>
                        <label htmlFor="service_id" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Select Service
                        </label>
                        <select
                            id="service_id"
                            value={data.service_id}
                            onChange={(e) => setData('service_id', e.target.value)}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                        >
                            <option value="">Choose a service...</option>
                            {services.map((service: any) => (
                                <option key={service.id} value={service.id}>
                                    {service.name} - BDT {service.price}
                                </option>
                            ))}
                        </select>
                        {errors.service_id && (
                            <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.service_id}</p>
                        )}
                    </div>

                    <div>
                        <label htmlFor="booking_date" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Booking Date
                        </label>
                        <input
                            type="date"
                            id="booking_date"
                            value={data.booking_date}
                            onChange={(e) => setData('booking_date', e.target.value)}
                            min={new Date(Date.now() + 86400000).toISOString().split('T')[0]} // Tomorrow
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                        />
                        {errors.booking_date && (
                            <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.booking_date}</p>
                        )}
                    </div>

                    {/* Service Details */}
                    {data.service_id && (
                        <div className="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h3 className="font-medium text-gray-900 dark:text-white mb-2">Service Details</h3>
                            {services.filter((s: any) => s.id == data.service_id).map((service: any) => (
                                <div key={service.id}>
                                    <p className="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                        <strong>Name:</strong> {service.name}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                        <strong>Description:</strong> {service.description}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-400">
                                        <strong>Price:</strong> BDT {service.price}
                                    </p>
                                </div>
                            ))}
                        </div>
                    )}

                    <div className="flex justify-end space-x-4">
                        <Link
                            href="/dashboard"
                            className="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded hover:bg-gray-400 dark:hover:bg-gray-500"
                        >
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 disabled:opacity-50 dark:bg-indigo-500 dark:hover:bg-indigo-600"
                        >
                            Book Service
                        </button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}