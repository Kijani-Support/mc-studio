import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { ThemeProvider } from './components/Context/ThemeContext'; // <-- Import the ThemeProvider

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
      
      <ThemeProvider>
        <Router>
            <Routes>
              {/* Homepage */}
              <Route path="/" element={<HomePage/>} />
              {/* StartUpDirectoryPage */}
              <Route path="/directory" element={<StartUpProfilePage/>} />
              {/* StartUpProfilePage */}
              <Route path="/profile" element={<StartUpDirectoryPage/>} />
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
      </ThemeProvider>
    </div>
  );
}

export default App;