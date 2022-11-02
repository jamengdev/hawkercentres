import { Head } from "@inertiajs/inertia-react";

export default function Welcome({ hawker }) {
    const data = JSON.parse(hawker.api_data);

    return (
        <>
            <Head title={data.name} />
            <div className="h-screen px-4 mt-24 lg:mt-0 lg:flex lg:flex-col lg:items-center lg:justify-center">
                <div className="text-5xl text-center mb-4">{data.name}</div>
                <div className="text-3xl text-center mb-2">
                    Scheduled Cleaning
                </div>
                <div>
                    {data.q1_cleaningenddate} to {data.q1_cleaningstartdate}
                </div>
                <div>
                    {data.q2_cleaningenddate} to {data.q2_cleaningstartdate}
                </div>
                <div>
                    {data.q3_cleaningenddate} to {data.q3_cleaningstartdate}
                </div>
                <div>
                    {data.q4_cleaningenddate} to {data.q4_cleaningstartdate}
                </div>
            </div>
        </>
    );
}
