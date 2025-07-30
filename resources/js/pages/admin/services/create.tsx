import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, Link, useForm } from "@inertiajs/react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Services',
        href: '/services',
    },
    {
        title: 'Add Service',
        href: `#`,
    },
];

export default function AdminServicesAdd() {

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        price: '',
        status: 'active'
    })

    const submit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        post('/services')
    }


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Add Service" />
            <div className="container max-w-5xl mx-auto mt-5">
                <div className="max-w-2xl mx-auto">
                    <div className="mb-8">
                        <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Add Service</h1>
                        <p className="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            Add a new service.
                        </p>
                    </div>
                    <form onSubmit={submit} className="space-y-6">
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Service Name
                            </label>
                            <input
                                type="text"
                                id="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            />
                            {errors.name && (
                                <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="description" className="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Description
                            </label>
                            <textarea
                                id="description"
                                rows={4}
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            />
                            {errors.description && (
                                <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.description}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="price" className="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Price (BDT)
                            </label>
                            <input
                                type="number"
                                id="price"
                                step="0.01"
                                value={data.price}
                                onChange={(e) => setData('price', e.target.value)}
                                className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            />
                            {errors.price && (
                                <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.price}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="status" className="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Status
                            </label>
                            <select
                                id="status"
                                value={data.status}
                                onChange={(e) => setData('status', e.target.value)}
                                className="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            {errors.status && (
                                <p className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.status}</p>
                            )}
                        </div>

                        <div className="flex justify-end space-x-4">
                            <Link
                                href="/services"
                                className="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded hover:bg-gray-400 dark:hover:bg-gray-600"
                            >
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="bg-indigo-600 dark:bg-indigo-700 text-white px-4 py-2 rounded hover:bg-indigo-700 dark:hover:bg-indigo-800 disabled:opacity-50"
                            >
                                Add Service
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </AppLayout>
    );
}