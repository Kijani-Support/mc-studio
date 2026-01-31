import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import HomePage from './pages/HomePage';
import StartUpDirectoryPage from './pages/StartUpDirectoryPage';
import StartUpProfilePage from './pages/StartUpProfilePage';



function App() {
  return (
    <div className="App">
      <Router>
          <Routes>
            {/* Homepage */}
            <Route path="/" element={<HomePage/>} />
            {/* StartUpDirectoryPage */}
            <Route path="/directory" element={<StartUpDirectoryPage/>} />
            {/* StartUpDirectoryPage */}
            <Route path="/profile" element={<StartUpProfilePage/>} />
          </Routes>
      </Router>
    </div>
  );
}

export default App;