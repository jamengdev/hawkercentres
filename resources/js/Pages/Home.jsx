import { useState } from "react";
import { Link, Head } from "@inertiajs/inertia-react";
import { Combobox } from "@headlessui/react";

const people = [
    "Durward Reynolds",
    "Kenton Towne",
    "Therese Wunsch",
    "Benedict Kessler",
    "Katelyn Rohan",
];

export default function Welcome(props) {
    const [selectedPerson, setSelectedPerson] = useState(people[0]);
    const [query, setQuery] = useState("");

    const filteredPeople =
        query === ""
            ? people
            : people.filter((person) => {
                  return person.toLowerCase().includes(query.toLowerCase());
              });

    return (
        <>
            <Head title="Home" />
            <div className="flex flex-col items-center justify-center h-screen">
                <div className="mb-4">hawker open or not?</div>
                <div>
                    <Combobox
                        value={selectedPerson}
                        onChange={setSelectedPerson}
                    >
                        <Combobox.Input
                            onChange={(event) => setQuery(event.target.value)}
                        />
                        <Combobox.Options>
                            {filteredPeople.map((person) => (
                                <Combobox.Option key={person} value={person}>
                                    {person}
                                </Combobox.Option>
                            ))}
                        </Combobox.Options>
                    </Combobox>
                </div>
            </div>
        </>
    );
}
