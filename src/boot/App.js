import { HashRouter, Route, Routes } from "react-router-dom";
import CreateRules from "@pages/Rules/CreateRules";
import Rules from "@pages/Rules/Rules";
import Integrations from "@pages/Integrations/Integrations";

function App() {
  return (
    <>
      <HashRouter>
        <Routes>
          <Route path="/" element={<Rules />} />
          <Route path="/rule" element={<CreateRules />} />
          <Route path="/rule/:id" element={<CreateRules />} />
          <Route path="/integrations" element={<Integrations />} />
        </Routes>
      </HashRouter>
    </>
  );
}

export default App;