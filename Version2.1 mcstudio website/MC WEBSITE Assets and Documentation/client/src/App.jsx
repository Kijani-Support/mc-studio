import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import HomePage from './pages/HomePage';
import StartUpDirectoryPage from './pages/StartUpDirectoryPage';
import StartUpProfilePage from './pages/StartUpProfilePage';
import ProjectsPage from './pages/ProjectsPage';
import CaseStudies from './pages/CaseStudies';
import ArticleDetail from './pages/ArticleDetail';
import Services from './pages/Services';



function App() {
  return (
    <div className="App">
      <Router>
          <Routes>
            {/* Homepage */}
            <Route path="/" element={<HomePage/>} />
            {/* StartUpDirectoryPage */}
            <Route path="/directory" element={<StartUpDirectoryPage/>} />
            {/* StartUpProfilePage */}
            <Route path="/profile" element={<StartUpProfilePage/>} />
            {/* ProjectsPage */}
            <Route path="/projects" element={<ProjectsPage/>} />
            {/* CaseStudies */}
            <Route path="/case-studies" element={<CaseStudies/>} />
            {/* ArticleDetail */}
            <Route path="/article/:id" element={<ArticleDetail/>} />
            {/* Services */}
            <Route path="/services" element={<Services/>} />
          </Routes>
      </Router>
    </div>
  );
}

export default App;