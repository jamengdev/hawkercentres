import { Head, Link } from "@inertiajs/inertia-react";

export default function Welcome({
    hawker,
    isOpenNow,
    nextScheduledCleaningDate,
}) {
    const data = JSON.parse(hawker.api_data);

    return (
        <>
            <Head title={data.name} />
            <div className="px-10 lg:flex lg:flex-col lg:items-center lg:justify-center">
                <div className="flex flex-col max-w-7xl">
                    <div className="my-10 text-3xl lg:text-5xl text-center">
                        Hawker open or not?
                    </div>
                    <div className="bg-[#F5F5F5] w-full rounded-[1rem] flex flex-col justify-center items-center py-10 px-6 lg:py-20 lg:px-10">
                        <img
                            className="w-20 lg:w-32 mb-6"
                            src={
                                isOpenNow
                                    ? "/images/open.png"
                                    : "/images/closed.png"
                            }
                        />
                        <div className="text-2xl lg:text-4xl font-bold text-center mb-2">
                            {data.name}
                        </div>
                        <div className="text-xl lg:text-2xl text-center mb-10">
                            {data.address_myenv}
                        </div>
                        <div className="flex flex-col lg:flex-row justify-center items-center bg-[#FFF4C1] px-10 py-6">
                            <img
                                className="w-12 h-12 lg:w-16 lg:h-16 mr-6 mb-4 lg:mb-0"
                                src="/images/bucket.png"
                            />
                            <div className="flex flex-col items-center justify-center">
                                <div className="text-xl lg:text-2xl text-center">
                                    Next scheduled cleaning date
                                </div>
                                <div className="text-xl lg:text-2xl font-bold text-center">
                                    {nextScheduledCleaningDate}
                                </div>
                            </div>
                        </div>
                    </div>
                    <Link
                        className="my-10 text-center text-[#E50027] text-xl underline"
                        href="/"
                    >
                        Search another hawker centre
                    </Link>
                    <div className="mb-4 text-center text-[#a99743]">
                        Designed and built because we wanted to eat, but hawker
                        centre was closed for cleaning. Data from
                        https://data.gov.sg/ ♥
                    </div>
                </div>
            </div>
        </>
    );
}
