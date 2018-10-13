import * as React from "react";
import * as ReactDOM from "react-dom";

import { Listado } from "./components/Listado";

ReactDOM.render(
    <Listado compiler="TypeScript" framework="React" />,
    document.getElementById("example")
);