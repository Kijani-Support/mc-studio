@extends('layouts.app')

@section('title', 'IBM Technology Training - Developer Application')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }
    
    .container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        width: 100%;
        overflow: hidden;
        animation: slideIn 0.8s ease-out;
        margin: 0 auto;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
        position: relative;
    }
    
    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    }
    
    .header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
        font-weight: 300;
        position: relative;
        z-index: 1;
    }
    
    .header p {
        font-size: 1.2em;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    
    .ibm-logo {
        position: absolute;
        top: 20px;
        right: 30px;
        font-weight: bold;
        font-size: 1.5em;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .content {
        padding: 40px 30px;
    }
    
    .program-overview {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        color: white;
        text-align: center;
    }
    
    .program-overview h2 {
        font-size: 1.8em;
        margin-bottom: 15px;
    }
    
    .highlights {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }
    
    .highlight-card {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .highlight-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .highlight-card h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .form-section {
        margin-bottom: 30px;
    }
    
    .form-section h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 1.4em;
        border-bottom: 2px solid #667eea;
        padding-bottom: 10px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #34495e;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }
    
    .checkbox-item {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #f8f9ff;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    
    .checkbox-item:hover {
        background: #e8edff;
    }
    
    .checkbox-item input[type="checkbox"] {
        width: auto;
        margin-right: 10px;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100%;
        margin-top: 20px;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    
    .required {
        color: #e74c3c;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .header h1 {
            font-size: 2em;
        }
        
        .content {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success w-75 mx-auto">{{ session('success') }}</div>
    @endif
    <div class="header">
        <div class="ibm-logo">IBM</div>
        <h1>8-Week IBM Technology Training</h1>
        <p>Comprehensive Watson AI & Cloud Development Program</p>
    </div>
    
    <div class="content">
        <div class="program-overview">
            <h2>🚀 Transform Your Career with IBM Technology</h2>
            <p>Join an exclusive 8-week intensive training program designed to certify you in cutting-edge IBM technologies including Watson AI, Cloud Computing, and Machine Learning solutions.</p>
        </div>
        
        <div class="highlights">
            <div class="highlight-card">
                <h3>🎯 Duration</h3>
                <p>8 Weeks Intensive<br>Mon-Fri, 9:00 AM - 4:00 PM</p>
            </div>
            <div class="highlight-card">
                <h3>🏆 Certification</h3>
                <p>IBM Official Badges<br>Industry-Recognized Credentials</p>
            </div>
            <div class="highlight-card">
                <h3>💼 Placement</h3>
                <p>Job Placement Support<br>Enterprise Project Deployment</p>
            </div>
            <div class="highlight-card">
                <h3>🌐 Format</h3>
                <p>Virtual + In-Person Labs<br>24/7 Learning Support</p>
            </div>
        </div>
        
        <form id="applicationForm" method="POST" action="{{ route('leads.store') }}">
            @csrf
            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name <span class="required">*</span></label>
                        <input type="text" id="firstName" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name <span class="required">*</span></label>
                        <input type="text" id="lastName" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Full residential address">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-section">
                <h3>Professional Background</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="education">Education Level <span class="required">*</span></label>
                        <select id="education" name="education" required>
                            <option value="">Select Education Level</option>
                            <option value="diploma" {{ old('education') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="bachelor" {{ old('education') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                            <option value="master" {{ old('education') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                            <option value="phd" {{ old('education') == 'phd' ? 'selected' : '' }}>PhD</option>
                            <option value="other" {{ old('education') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('education')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="experience">Years of IT Experience <span class="required">*</span></label>
                        <select id="experience" name="experience" required>
                            <option value="">Select Experience</option>
                            <option value="0-1" {{ old('experience') == '0-1' ? 'selected' : '' }}>0-1 years (Fresh Graduate)</option>
                            <option value="2-3" {{ old('experience') == '2-3' ? 'selected' : '' }}>2-3 years</option>
                            <option value="4-5" {{ old('experience') == '4-5' ? 'selected' : '' }}>4-5 years</option>
                            <option value="6-10" {{ old('experience') == '6-10' ? 'selected' : '' }}>6-10 years</option>
                            <option value="10+" {{ old('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                        </select>
                        @error('experience')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="currentRole">Current Role/Position</label>
                    <input type="text" id="currentRole" name="current_role" value="{{ old('current_role') }}" placeholder="e.g., Software Developer, IT Analyst">
                    @error('current_role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="company">Current/Previous Company</label>
                    <input type="text" id="company" name="company" value="{{ old('company') }}" placeholder="Company name">
                    @error('company')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-section">
                <h3>Technical Skills Assessment</h3>
                <div class="form-group">
                    <label>Programming Languages (Select all that apply)</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="python" name="languages[]" value="python" {{ in_array('python', old('languages', [])) ? 'checked' : '' }}>
                            <label for="python">Python</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="java" name="languages[]" value="java" {{ in_array('java', old('languages', [])) ? 'checked' : '' }}>
                            <label for="java">Java</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="javascript" name="languages[]" value="javascript" {{ in_array('javascript', old('languages', [])) ? 'checked' : '' }}>
                            <label for="javascript">JavaScript</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="nodejs" name="languages[]" value="nodejs" {{ in_array('nodejs', old('languages', [])) ? 'checked' : '' }}>
                            <label for="nodejs">Node.js</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="csharp" name="languages[]" value="csharp" {{ in_array('csharp', old('languages', [])) ? 'checked' : '' }}>
                            <label for="csharp">C#</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="other-lang" name="languages[]" value="other" {{ in_array('other', old('languages', [])) ? 'checked' : '' }}>
                            <label for="other-lang">Other</label>
                        </div>
                    </div>
                    @error('languages')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Cloud Platforms Experience</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="ibm-cloud" name="cloud_platforms[]" value="ibm-cloud" {{ in_array('ibm-cloud', old('cloud_platforms', [])) ? 'checked' : '' }}>
                            <label for="ibm-cloud">IBM Cloud</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="aws" name="cloud_platforms[]" value="aws" {{ in_array('aws', old('cloud_platforms', [])) ? 'checked' : '' }}>
                            <label for="aws">AWS</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="azure" name="cloud_platforms[]" value="azure" {{ in_array('azure', old('cloud_platforms', [])) ? 'checked' : '' }}>
                            <label for="azure">Microsoft Azure</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="gcp" name="cloud_platforms[]" value="gcp" {{ in_array('gcp', old('cloud_platforms', [])) ? 'checked' : '' }}>
                            <label for="gcp">Google Cloud</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="no-cloud" name="cloud_platforms[]" value="none" {{ in_array('none', old('cloud_platforms', [])) ? 'checked' : '' }}>
                            <label for="no-cloud">No Cloud Experience</label>
                        </div>
                    </div>
                    @error('cloud_platforms')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="ai-experience">AI/Machine Learning Experience Level <span class="required">*</span></label>
                    <select id="ai-experience" name="ai_experience" required>
                        <option value="">Select Experience Level</option>
                        <option value="none" {{ old('ai_experience') == 'none' ? 'selected' : '' }}>No Experience</option>
                        <option value="basic" {{ old('ai_experience') == 'basic' ? 'selected' : '' }}>Basic (Familiar with concepts)</option>
                        <option value="intermediate" {{ old('ai_experience') == 'intermediate' ? 'selected' : '' }}>Intermediate (Some hands-on experience)</option>
                        <option value="advanced" {{ old('ai_experience') == 'advanced' ? 'selected' : '' }}>Advanced (Professional experience)</option>
                    </select>
                    @error('ai_experience')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-section">
                <h3>Training Preferences & Commitment</h3>
                <div class="form-group">
                    <label for="availability">Can you commit to full-time training (9:00 AM - 4:00 PM, Mon-Fri)? <span class="required">*</span></label>
                    <select id="availability" name="availability" required>
                        <option value="">Select Option</option>
                        <option value="yes" {{ old('availability') == 'yes' ? 'selected' : '' }}>Yes, I can commit full-time</option>
                        <option value="partial" {{ old('availability') == 'partial' ? 'selected' : '' }}>Partial availability (please explain below)</option>
                        <option value="no" {{ old('availability') == 'no' ? 'selected' : '' }}>No, I cannot commit full-time</option>
                    </select>
                    @error('availability')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="motivation">Why are you interested in this IBM training program? <span class="required">*</span></label>
                    <textarea id="motivation" name="motivation" rows="4" placeholder="Describe your career goals and how this training aligns with them" required>{{ old('motivation') }}</textarea>
                    @error('motivation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="specialization">Which IBM technology area interests you most? <span class="required">*</span></label>
                    <select id="specialization" name="specialization" required>
                        <option value="">Select Specialization</option>
                        <option value="watson-ai" {{ old('specialization') == 'watson-ai' ? 'selected' : '' }}>Watson AI & Machine Learning</option>
                        <option value="cloud" {{ old('specialization') == 'cloud' ? 'selected' : '' }}>IBM Cloud Infrastructure</option>
                        <option value="data" {{ old('specialization') == 'data' ? 'selected' : '' }}>Data & Analytics</option>
                        <option value="security" {{ old('specialization') == 'security' ? 'selected' : '' }}>Cybersecurity</option>
                        <option value="integration" {{ old('specialization') == 'integration' ? 'selected' : '' }}>Integration & APIs</option>
                        <option value="all" {{ old('specialization') == 'all' ? 'selected' : '' }}>All areas equally</option>
                    </select>
                    @error('specialization')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="additional-info">Additional Information</label>
                    <textarea id="additional-info" name="additional_info" rows="3" placeholder="Any additional information you'd like to share (previous IBM experience, portfolio links, etc.)">{{ old('additional_info') }}</textarea>
                    @error('additional_info')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-section">
                <h3>Equipment & Technical Requirements</h3>
                <div class="form-group">
                    <label for="laptop">Do you have access to a laptop for training? <span class="required">*</span></label>
                    <select id="laptop" name="laptop_access" required>
                        <option value="">Select Option</option>
                        <option value="yes" {{ old('laptop_access') == 'yes' ? 'selected' : '' }}>Yes, I have a suitable laptop</option>
                        <option value="need-support" {{ old('laptop_access') == 'need-support' ? 'selected' : '' }}>I need laptop support</option>
                        <option value="no" {{ old('laptop_access') == 'no' ? 'selected' : '' }}>No, I don't have access to a laptop</option>
                    </select>
                    @error('laptop_access')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="internet">Internet Connection Quality</label>
                    <select id="internet" name="internet_quality">
                        <option value="">Select Connection Quality</option>
                        <option value="excellent" {{ old('internet_quality') == 'excellent' ? 'selected' : '' }}>Excellent (High-speed broadband)</option>
                        <option value="good" {{ old('internet_quality') == 'good' ? 'selected' : '' }}>Good (Stable broadband)</option>
                        <option value="fair" {{ old('internet_quality') == 'fair' ? 'selected' : '' }}>Fair (Basic internet)</option>
                        <option value="poor" {{ old('internet_quality') == 'poor' ? 'selected' : '' }}>Poor/Unreliable</option>
                    </select>
                    @error('internet_quality')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                🚀 Submit Application
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('applicationForm').addEventListener('submit', function(e) {
        // Form validation
        const requiredFields = this.querySelectorAll('[required]');
        let allValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#e74c3c';
                allValid = false;
            } else {
                field.style.borderColor = '#e0e6ed';
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            alert('Please fill in all required fields marked with *');
        }
    });
    
    // Dynamic form interactions
    document.getElementById('experience').addEventListener('change', function() {
        const eduField = document.getElementById('education');
        if (this.value === '0-1' && !eduField.value) {
            eduField.focus();
        }
    });
    
    // Real-time validation
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#e0e6ed';
            }
        });
    });
</script>
@endpush