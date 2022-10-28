import { Fragment, useEffect, useState } from "react";
import { Head } from "@inertiajs/inertia-react";
import { Combobox, Transition } from "@headlessui/react";

export default function Welcome(props) {
    const [hawkers, setHawkers] = useState([]);
    const [selectedHawker, setSelectedHawker] = useState("");
    const [query, setQuery] = useState("");
    const [filtered, setFiltered] = useState([]);

    useEffect(() => {
        let serializedData = props.hawkers.map((hawker) =>
            JSON.parse(hawker.api_data)
        );

        setHawkers(serializedData);
    }, []);

    useEffect(() => {
        if (query === "") {
            setFiltered([]);
            return;
        }

        let filteredHawker = hawkers.filter((hawker) => {
            return hawker.name.toLowerCase().includes(query.toLowerCase());
        });

        filteredHawker.length > 0
            ? setFiltered(filteredHawker.slice(0, 5))
            : setFiltered([]);
    }, [query]);

    return (
        <>
            <Head title="Home" />
            <div class="h-screen px-4 flex flex-col items-center justify-center bg-[#f2d860]">
                <div className="mb-12">
                    <FloatingIcons />
                </div>
                <div className="mb-4 text-3xl lg:text-5xl text-center">Hawker open or not?</div>
                <div className="mb-6 text-xl lg:text-3xl text-center">
                    Find out when hawker centres are open or closed for cleaning
                </div>
                <div className="max-w-3xl mx-auto w-full relative">
                    <Combobox
                        value={selectedHawker}
                        onChange={setSelectedHawker}
                    >
                        <Combobox.Input
                            className={`w-full h-11 border-none focus:ring-0 shadow-md shadow-[#ffc700] ${
                                query ? "rounded-t-3xl" : "rounded-3xl"
                            }`}
                            onChange={(event) => setQuery(event.target.value)}
                            displayValue={(hawker) => hawker.name}
                        />
                        <Transition
                            as={Fragment}
                            leave=""
                            leaveFrom="opacity-100"
                            leaveTo="opacity-0"
                            afterLeave={() => setQuery("")}
                        >
                            <div className="absolute max-w-3xl w-full bg-white rounded-b-3xl">
                                <Combobox.Options>
                                    {filtered.map((hawker) => (
                                        <Combobox.Option
                                            key={hawker._id}
                                            value={hawker}
                                            className={({ active }) =>
                                                `relative cursor-default select-none py-2 pl-10 pr-4 ${
                                                    active
                                                        ? "bg-[#f2d860] text-black bg-opacity-25"
                                                        : "text-black"
                                                }`
                                            }
                                        >
                                            {hawker.name}
                                        </Combobox.Option>
                                    ))}
                                </Combobox.Options>
                            </div>
                        </Transition>
                    </Combobox>
                </div>
            </div>
        </>
    );
}

const FloatingIcons = () => {
    return (
        <div className="flex space-x-12 overflow-hidden">
            <img className="w-20" src="/images/ramen-one.png" />
            <img className="w-20" src="/images/ramen-two.png" />
            <img className="w-20" src="/images/curry-rice-one.png" />
            <img className="w-20" src="/images/ramen-one.png" />
            <img className="w-20" src="/images/ramen-two.png" />
            <img className="w-20" src="/images/curry-rice-one.png" />
            <img className="w-20" src="/images/ramen-one.png" />
            <img className="w-20" src="/images/ramen-two.png" />
            <img className="w-20" src="/images/curry-rice-one.png" />
        </div>
    );
};
