import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import HomePage from './pages/HomePage';



function App() {
  return (
    <div className="App">
      <Router>
          <Routes>
            {/* Homepage */}
            <Route path="/" element={<HomePage/>} />
          </Routes>
      </Router>
    </div>
  );
}

export default App;