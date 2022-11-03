import { Head, Link } from "@inertiajs/inertia-react";

export default function ErrorPage({ status }) {
    const description = {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers. Please check back soon.",
        404: "Hawker Centre Not Found",
        403: "Sorry, you are forbidden from accessing this page.",
    }[status];

    return (
        <div className="px-10 lg:flex lg:flex-col lg:items-center lg:justify-center">
            <div className="flex flex-col max-w-7xl w-full">
                <div className="flex justify-center">
                    <img
                        className="my-6 lg:my-10 w-full max-w-lg"
                        src="/images/logo.png"
                    />
                </div>
                <div className="relative bg-[#F5F5F5] w-full rounded-[1rem] flex flex-col justify-center items-center py-10 px-6 lg:py-20 lg:px-10 mb-10">
                    <img className="w-20 lg:w-32 mb-6" src="/images/lost.png" />
                    <div className="text-2xl lg:text-4xl font-bold text-center">
                        {description}
                    </div>
                    <Link
                        className="my-10 mb-20 text-center text-[#E50027] text-xl underline"
                        href="/"
                    >
                        Search another hawker centre
                    </Link>
                    <div className="absolute bottom-0 text-[#F2C060]">
                        <div className="flex flex-col items-center space-y-2">
                            <div>meow</div>
                            <div className="flex space-x-2 items-center">
                                <div>meow</div>
                                <img
                                    className="w-10 lg:w-16"
                                    src="/images/cat.png"
                                />
                                <div>meow</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="mb-4 text-center text-[#a99743]">
                    Designed and built because we wanted to eat, but hawker
                    centre was closed for cleaning. Data from
                    https://data.gov.sg/ ♥
                </div>
            </div>
        </div>
    );
}
