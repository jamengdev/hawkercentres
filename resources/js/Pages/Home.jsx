import { Fragment, useEffect, useState } from "react";
import { Head, Link } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";
import { Combobox, Transition } from "@headlessui/react";

export default function Welcome(props) {
    const [hawkers, setHawkers] = useState([]);
    const [selectedHawker, setSelectedHawker] = useState("");
    const [query, setQuery] = useState("");
    const [filtered, setFiltered] = useState([]);

    useEffect(() => {
        // todo: how to not manipulate the data like this?
        let serializedData = props.hawkers.map((hawker) => {
            let obj = Object.assign({});
            obj = JSON.parse(hawker.api_data);
            obj.url = hawker.url;
            return obj;
        });

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
            <Head title="Hawkers" />
            <div className="px-10 lg:flex lg:flex-col lg:items-center lg:justify-center">
                <div className="flex flex-col max-w-7xl">
                    <div className="mt-20 mb-6 lg:mt-40 lg:mb-12">
                        <FloatingIcons />
                    </div>
                    <div className="mb-4 text-3xl lg:text-5xl text-center">
                        Hawker open or not?
                    </div>
                    <div className="mb-6 text-xl lg:text-3xl text-center">
                        Find out when hawker centres are open or closed for
                        cleaning
                    </div>
                    <div className="max-w-3xl mx-auto w-full relative">
                        <Combobox
                            value={selectedHawker}
                            onChange={(value) => {
                                /* todo: can this be using named route instead? */
                                setSelectedHawker(value);
                                Inertia.get(`/hawkers/${value.url}`);
                            }}
                        >
                            <div className="absolute inset-y-0 left-0 flex items-center pl-5">
                                <img
                                    className="w-6"
                                    src="/images/map-pin.png"
                                />
                            </div>
                            <Combobox.Input
                                className={`w-full h-11 border-none focus:ring-0 shadow-md shadow-[#ffc700] pl-14 ${
                                    query ? "rounded-t-3xl" : "rounded-3xl"
                                }`}
                                onChange={(event) =>
                                    setQuery(event.target.value)
                                }
                                displayValue={(hawker) => hawker.name}
                            />
                            <Transition
                                as={Fragment}
                                leave=""
                                leaveFrom="opacity-100"
                                leaveTo="opacity-0"
                                afterLeave={() => setQuery("")}
                            >
                                <div className="absolute max-w-3xl w-full bg-white rounded-b-3xl shadow-md shadow-[#ffc700]">
                                    <Combobox.Options>
                                        {filtered.map((hawker) => (
                                            <Combobox.Option
                                                key={hawker._id}
                                                value={hawker}
                                                className={({ active }) =>
                                                    `relative cursor-default select-none py-2 pl-14 pr-4 ${
                                                        active
                                                            ? "bg-[#f2d860] text-black bg-opacity-25"
                                                            : "text-black"
                                                    }`
                                                }
                                            >
                                                <div>{hawker.name}</div>
                                            </Combobox.Option>
                                        ))}
                                        {query && filtered.length === 0 && (
                                            <Combobox.Option
                                                disabled={true}
                                                value={null}
                                                className="relative cursor-default select-none py-2 pl-14 pr-4 break-words"
                                            >
                                                <div>
                                                    We couldn't find "{query}"
                                                </div>
                                                <div className="text-xs text-gray-400">
                                                    Try searching for hawker
                                                    centre name or address
                                                </div>
                                            </Combobox.Option>
                                        )}
                                    </Combobox.Options>
                                </div>
                            </Transition>
                        </Combobox>
                    </div>
                    <div className="mt-10 my-4 text-center text-[#a99743]">
                        Designed and built because we wanted to eat, but hawker
                        centre was closed for cleaning. Data from
                        https://data.gov.sg/ ♥
                    </div>
                </div>
            </div>
        </>
    );
}

const FloatingIcons = () => {
    return (
        <div className="flex space-x-12 overflow-hidden">
            <img className="w-16 lg:w-20" src="/images/ramen-one.png" />
            <img className="w-16 lg:w-20" src="/images/ramen-two.png" />
            <img className="w-16 lg:w-20" src="/images/curry-rice-one.png" />
            <img className="w-16 lg:w-20" src="/images/ramen-one.png" />
            <img className="w-16 lg:w-20" src="/images/ramen-two.png" />
            <img className="w-16 lg:w-20" src="/images/curry-rice-one.png" />
            <img className="w-16 lg:w-20" src="/images/ramen-one.png" />
            <img className="w-16 lg:w-20" src="/images/ramen-two.png" />
            <img className="w-16 lg:w-20" src="/images/curry-rice-one.png" />
        </div>
    );
};
