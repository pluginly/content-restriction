import { HashRouter, Route, Routes } from "react-router-dom";
import CreateRule from "@pages/Rules/CreateRule";
import Rules from "@pages/Rules/Rules";
import Integrations from "@pages/Integrations/Integrations";
import UpdateRule from "@pages/Rules/UpdateRule";
import License from "@pages/License/License";
import Settings from "@pages/Settings/Settings";

function App() {
  return (
    <>
      <HashRouter>
        <Routes>
          <Route path="/" element={<Rules />} />
          <Route path="/rules" element={<Rules />} />
          <Route path="/rule" element={<CreateRule />} />
          <Route path="/rule/:id" element={<UpdateRule />} />
          <Route path="/integrations" element={<Integrations />} />
          <Route path="/settings" element={<Settings />} />
          <Route path="/license" element={<License />} />
        </Routes>
      </HashRouter>
    </>
  );
}

export default App;