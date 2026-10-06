@extends('layouts.app')

@section('content')
<!-- Header -->
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">DAIMA VENTURES</div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#apply">Apply Now</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container">
        <h1>Empowering Agricultural Communities</h1>
        <p>Transform your farming business with tailored financial solutions designed for Uganda's smallholder farmers and cooperatives. Access capital when you need it most.</p>
        <div class="cta-buttons">
            <a href="#apply" class="btn">Apply for Financing</a>
            <a href="#products" class="btn btn-secondary">Explore Products</a>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="products">
    <div class="container">
        <h2 class="section-title">Our Financial Products</h2>
        <div class="products-grid">
                <!-- Harvest Advance Loans -->
                <div class="product-card fade-in">
                    <div class="product-header">
                        <div class="product-icon">🌾</div>
                        <div>
                            <div class="product-title">Harvest Advance Loans</div>
                        </div>
                        <div class="status-badge available">Available Now</div>
                    </div>
                    <p class="product-description">Avoid distress sales and capture full market value for your produce. Get immediate cash flow while your crops are stored for better prices.</p>
                    <div class="product-terms">
                        <h4>Key Terms:</h4>
                        <div class="terms-list">
                            • Interest Rate: 16.9% per annum<br>
                            • Loan Size: UGX 5M - 200M<br>
                            • Term: 3-6 months<br>
                            • Collateral: Stored produce
                        </div>
                    </div>
                </div>

                <!-- Asset Acquisition Loans -->
                <div class="product-card fade-in">
                    <div class="product-header">
                        <div class="product-icon">🏗️</div>
                        <div>
                            <div class="product-title">Asset Acquisition & Development</div>
                        </div>
                        <div class="status-badge coming-soon">Coming Soon</div>
                    </div>
                    <p class="product-description">Build cooperative capacity through strategic investments in land, buildings, processing equipment, and other development assets.</p>
                    <div class="product-terms">
                        <h4>Key Terms:</h4>
                        <div class="terms-list">
                            • Interest Rate: 18% per annum<br>
                            • Loan Size: UGX 5M - 500M<br>
                            • Term: 6 months - 4 years<br>
                            • Customized repayment plans
                        </div>
                    </div>
                </div>

                <!-- Value Chain Loans -->
                <div class="product-card fade-in">
                    <div class="product-header">
                        <div class="product-icon">🚜</div>
                        <div>
                            <div class="product-title">Agricultural Value Chain Loans</div>
                        </div>
                        <div class="status-badge coming-soon">Coming Soon</div>
                    </div>
                    <p class="product-description">Comprehensive financing across the full agricultural production cycle - from land preparation to marketing your final products.</p>
                    <div class="product-terms">
                        <h4>Key Terms:</h4>
                        <div class="terms-list">
                            • Interest Rate: 15% per annum<br>
                            • Loan Size: UGX 10M - 500M<br>
                            • Term: 6 months - 4 years<br>
                            • Seasonal grace periods available
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>

<!-- KYC Form Section -->
<section id="apply" class="kyc-section">
    <div class="container">
        <h2 class="section-title">Apply for Financing</h2>
        <div class="form-container">
            @if(session('success'))
                <div class="success-message" style="display:block;">{{ session('success') }}</div>
            @endif
            <div class="success-message" id="successMessage">
                Thank you for your application! We will review your information and contact you within 3-5 business days.
            </div>

            <form id="kycForm" method="POST" action="{{ route('applications.store') }}">
                @csrf
                <!-- Personal Information -->
                <div class="form-section">
                        <h3>Personal Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name <span class="required">*</span></label>
                                <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" required>
                                @error('firstName')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name <span class="required">*</span></label>
                                <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" required>
                                @error('lastName')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dateOfBirth">Date of Birth <span class="required">*</span></label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" value="{{ old('dateOfBirth') }}" required>
                                @error('dateOfBirth')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender <span class="required">*</span></label>
                                <select id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nationalId">National ID Number <span class="required">*</span></label>
                                <input type="text" id="nationalId" name="nationalId" value="{{ old('nationalId') }}" required>
                                @error('nationalId')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number <span class="required">*</span></label>
                                <input type="tel" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}" placeholder="+256..." required>
                                @error('phoneNumber')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="form-section">
                        <h3>Address Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="district">District <span class="required">*</span></label>
                                <select id="district" name="district" required>
                                    <option value="">Select District</option>
                                    <option value="kampala" {{ old('district') == 'kampala' ? 'selected' : '' }}>Kampala</option>
                                    <option value="wakiso" {{ old('district') == 'wakiso' ? 'selected' : '' }}>Wakiso</option>
                                    <option value="mukono" {{ old('district') == 'mukono' ? 'selected' : '' }}>Mukono</option>
                                    <option value="jinja" {{ old('district') == 'jinja' ? 'selected' : '' }}>Jinja</option>
                                    <option value="mbarara" {{ old('district') == 'mbarara' ? 'selected' : '' }}>Mbarara</option>
                                    <option value="gulu" {{ old('district') == 'gulu' ? 'selected' : '' }}>Gulu</option>
                                    <option value="lira" {{ old('district') == 'lira' ? 'selected' : '' }}>Lira</option>
                                    <option value="masaka" {{ old('district') == 'masaka' ? 'selected' : '' }}>Masaka</option>
                                    <option value="other" {{ old('district') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('district')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subcounty">Sub-county <span class="required">*</span></label>
                                <input type="text" id="subcounty" name="subcounty" value="{{ old('subcounty') }}" required>
                                @error('subcounty')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="parish">Parish <span class=""></span></label>
                                <input type="text" id="parish" name="parish" value="{{ old('parish') }}">
                                @error('parish')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="village">Village <span class="required">*</span></label>
                                <input type="text" id="village" name="village" value="{{ old('village') }}" required>
                                @error('village')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cooperative Information -->
                    <div class="form-section">
                        <h3>Cooperative/Group Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="cooperativeName">Cooperative/Group Name <span class="required">*</span></label>
                                <input type="text" id="cooperativeName" name="cooperativeName" value="{{ old('cooperativeName') }}" required>
                                @error('cooperativeName')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="membershipNumber">Membership Number</label>
                                <input type="text" id="membershipNumber" name="membershipNumber" value="{{ old('membershipNumber') }}">
                                @error('membershipNumber')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="position">Position in Cooperative</label>
                                <select id="position" name="position">
                                    <option value="">Select Position</option>
                                    <option value="chairperson" {{ old('position') == 'chairperson' ? 'selected' : '' }}>Chairperson</option>
                                    <option value="secretary" {{ old('position') == 'secretary' ? 'selected' : '' }}>Secretary</option>
                                    <option value="treasurer" {{ old('position') == 'treasurer' ? 'selected' : '' }}>Treasurer</option>
                                    <option value="committee_member" {{ old('position') == 'committee_member' ? 'selected' : '' }}>Committee Member</option>
                                    <option value="ordinary_member" {{ old('position') == 'ordinary_member' ? 'selected' : '' }}>Ordinary Member</option>
                                </select>
                                @error('position')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="registrationNumber">Cooperative Registration Number</label>
                                <input type="text" id="registrationNumber" name="registrationNumber" value="{{ old('registrationNumber') }}">
                                @error('registrationNumber')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Agricultural Information -->
                    <div class="form-section">
                        <h3>Agricultural Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="primaryCrop">Primary Crop <span class="required">*</span></label>
                                <select id="primaryCrop" name="primaryCrop" required>
                                    <option value="">Select Primary Crop</option>
                                    <option value="coffee" {{ old('primaryCrop') == 'coffee' ? 'selected' : '' }}>Coffee</option>
                                    <option value="maize" {{ old('primaryCrop') == 'maize' ? 'selected' : '' }}>Maize</option>
                                    <option value="beans" {{ old('primaryCrop') == 'beans' ? 'selected' : '' }}>Beans</option>
                                    <option value="rice" {{ old('primaryCrop') == 'rice' ? 'selected' : '' }}>Rice</option>
                                    <option value="groundnuts" {{ old('primaryCrop') == 'groundnuts' ? 'selected' : '' }}>Groundnuts</option>
                                    <option value="cassava" {{ old('primaryCrop') == 'cassava' ? 'selected' : '' }}>Cassava</option>
                                    <option value="sweet_potatoes" {{ old('primaryCrop') == 'sweet_potatoes' ? 'selected' : '' }}>Sweet Potatoes</option>
                                    <option value="bananas" {{ old('primaryCrop') == 'bananas' ? 'selected' : '' }}>Bananas</option>
                                    <option value="other" {{ old('primaryCrop') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('primaryCrop')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="farmSize">Farm Size (Acres) <span class="required">*</span></label>
                                <input type="number" id="farmSize" name="farmSize" value="{{ old('farmSize') }}" min="0" step="0.1" required>
                                @error('farmSize')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="annualProduction">Annual Production (Kg)</label>
                                <input type="number" id="annualProduction" name="annualProduction" value="{{ old('annualProduction') }}" min="0">
                                @error('annualProduction')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="farmingExperience">Years of Farming Experience</label>
                                <input type="number" id="farmingExperience" name="farmingExperience" value="{{ old('farmingExperience') }}" min="0">
                                @error('farmingExperience')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <div class="form-section">
                        <h3>Financial Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="loanAmount">Requested Loan Amount (UGX) <span class="required">*</span></label>
                                <input type="number" id="loanAmount" name="loanAmount" value="{{ old('loanAmount') }}" min="5000000" max="500000000" required>
                                @error('loanAmount')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="loanPurpose">Loan Purpose <span class="required">*</span></label>
                                <select id="loanPurpose" name="loanPurpose" required>
                                    <option value="">Select Purpose</option>
                                    <option value="harvest_advance" {{ old('loanPurpose') == 'harvest_advance' ? 'selected' : '' }}>Harvest Advance</option>
                                    <option value="asset_acquisition" {{ old('loanPurpose') == 'asset_acquisition' ? 'selected' : '' }}>Asset Acquisition</option>
                                    <option value="value_chain" {{ old('loanPurpose') == 'value_chain' ? 'selected' : '' }}>Value Chain Financing</option>
                                    <option value="working_capital" {{ old('loanPurpose') == 'working_capital' ? 'selected' : '' }}>Working Capital</option>
                                </select>
                                @error('loanPurpose')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="monthlyIncome">Monthly Income (UGX)</label>
                                <input type="number" id="monthlyIncome" name="monthlyIncome" value="{{ old('monthlyIncome') }}" min="0">
                                @error('monthlyIncome')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bankAccount">Do you have a bank account? <span class="required">*</span></label>
                                <select id="bankAccount" name="bankAccount" required>
                                    <option value="">Select</option>
                                    <option value="yes" {{ old('bankAccount') == 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('bankAccount') == 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('bankAccount')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Consent and Declarations -->
                    <div class="form-section">
                        <h3>Consent and Declarations</h3>
                        <div class="checkbox-group">
                            <input type="hidden" name="dataConsent" value="0">
                            <input type="checkbox" id="dataConsent" name="dataConsent" value="1" {{ old('dataConsent') ? 'checked' : '' }} required>
                            <label for="dataConsent">I consent to Daima Ventures processing my personal data for the purpose of loan assessment and as required by UMRA regulations. <span class="required">*</span></label>
                            @error('dataConsent')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="checkbox-group">
                            <input type="hidden" name="creditCheck" value="0">
                            <input type="checkbox" id="creditCheck" name="creditCheck" value="1" {{ old('creditCheck') ? 'checked' : '' }} required>
                            <label for="creditCheck">I authorize Daima Ventures to conduct credit checks and verify information provided. <span class="required">*</span></label>
                            @error('creditCheck')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="checkbox-group">
                            <input type="hidden" name="termsAccept" value="0">
                            <input type="checkbox" id="termsAccept" name="termsAccept" value="1" {{ old('termsAccept') ? 'checked' : '' }} required>
                            <label for="termsAccept">I have read and agree to the terms and conditions of Daima Ventures financial products. <span class="required">*</span></label>
                            @error('termsAccept')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="checkbox-group">
                            <input type="hidden" name="accurateInfo" value="0">
                            <input type="checkbox" id="accurateInfo" name="accurateInfo" value="1" {{ old('accurateInfo') ? 'checked' : '' }} required>
                            <label for="accurateInfo">I declare that all information provided is accurate and complete to the best of my knowledge. <span class="required">*</span></label>
                            @error('accurateInfo')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Submit Application</button>
                    </div>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="contact">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contact Us</h3>
                <div class="contact-info">Kampala Headquarters</div>
                <div class="contact-info">📞 +256-700331750 (Suuna)</div>
                <div class="contact-info">✉️ info@daimaventures.org</div>
            </div>
            <div class="footer-section">
                <h3>Our Mission</h3>
                <p>Building sustainable agricultural value chains by providing timely financing solutions to cooperatives and farmer groups across Uganda.</p>
            </div>
            <div class="footer-section">
                <h3>Regulatory Information</h3>
                <p>Daima Ventures is a registered financial services provider soon to be licensed by the Uganda Microfinance Regulatory Authority (UMRA).</p>
            </div>
        </div>
        <div style="border-top: 1px solid #4a7c23; padding-top: 2rem; margin-top: 2rem;">
            <p>&copy; 2025 Daima Ventures. All rights reserved. Transforming agricultural finance. Empowering rural communities.</p>
        </div>
    </div>
</footer>
@endsection

@push('styles')
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c23 50%, #6ba832 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
            color: #2d5016;
            display: flex;
            align-items: center;
        }
        
        .logo::before {
            content: "🌱";
            margin-right: 10px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        nav a:hover {
            color: #6ba832;
        }
        
        /* Hero Section */
        .hero {
            padding: 4rem 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out 0.2s both;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s both;
        }
        
        .btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
            box-shadow: none;
        }
        
        .btn-secondary:hover {
            background: white;
            color: #2d5016;
        }
        
        /* Products Section */
        .products {
            padding: 4rem 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #2d5016;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            border-radius: 2px;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .product-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(107, 168, 50, 0.1);
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }
        
        .product-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .product-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .product-title {
            font-size: 1.3rem;
            color: #2d5016;
            font-weight: bold;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: auto;
        }
        
        .available {
            background: #d4edda;
            color: #155724;
        }
        
        .coming-soon {
            background: #fff3cd;
            color: #856404;
        }
        
        .product-description {
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .product-terms {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid #6ba832;
        }
        
        .product-terms h4 {
            color: #2d5016;
            margin-bottom: 0.5rem;
        }
        
        .terms-list {
            font-size: 0.9rem;
            color: #555;
        }
        
        /* KYC Form Section */
        .kyc-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2d5016;
        }
        
        .required {
            color: #dc3545;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #6ba832;
            box-shadow: 0 0 0 3px rgba(107, 168, 50, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 1rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-top: 4px;
        }
        
        .form-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid #6ba832;
        }
        
        .form-section h3 {
            color: #2d5016;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        /* Footer */
        footer {
            background: #2d5016;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            color: #6ba832;
        }
        
        .contact-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .contact-info::before {
            content: "📍";
            margin-right: 10px;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .form-container {
                margin: 0 1rem;
                padding: 2rem;
            }
            
            nav {
                display: none;
            }
        }
        
        /* Success Message */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
            display: none;
        }
        .error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        /* Enhanced mobile responsiveness */
        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .btn {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
        }
        
        /* Print styles for form */
        @media print {
            header, .hero, .products, footer {
                display: none;
            }
            
            .kyc-section {
                background: white;
                padding: 0;
            }
            
            .form-container {
                box-shadow: none;
                border: 1px solid #ccc;
            }
            
            .btn {
                display: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
         // Smooth scrolling for navigation links
         document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form submission handling
        // Remove this block to allow normal form submission
        // document.getElementById('kycForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
            
        //     // Show success message
        //     const successMessage = document.getElementById('successMessage');
        //     successMessage.style.display = 'block';
            
        //     // Scroll to top of form
        //     document.getElementById('apply').scrollIntoView({
        //         behavior: 'smooth',
        //         block: 'start'
        //     });
            
        //     // Reset form after a delay
        //     setTimeout(() => {
        //         this.reset();
        //         successMessage.style.display = 'none';
        //     }, 5000);
        // });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });

        // Form validation enhancements
        const form = document.getElementById('kycForm');
        const inputs = form.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            const errorElement = field.nextElementSibling;
            
            // Remove existing error styling
            field.classList.remove('error');
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.remove();
            }

            let isValid = true;
            let errorMessage = '';

            // Required field validation
            if (field.hasAttribute('required') && !field.value.trim()) {
                isValid = false;
                errorMessage = 'This field is required.';
            }

            // Specific field validations
            switch (field.id) {
                case 'phoneNumber':
                    if (field.value && !field.value.match(/^\+256[0-9]{9}$/)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid Ugandan phone number (+256xxxxxxxxx)';
                    }
                    break;
                    
                case 'email':
                    if (field.value && !field.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                        isValid = false;
                        errorMessage = 'Please enter a valid email address.';
                    }
                    break;
                    
                case 'nationalId':
                    if (field.value && field.value.length < 14) {
                        isValid = false;
                        errorMessage = 'National ID must be at least 14 characters.';
                    }
                    break;
                    
                case 'loanAmount':
                    const amount = parseInt(field.value);
                    if (field.value && (amount < 5000000 || amount > 500000000)) {
                        isValid = false;
                        errorMessage = 'Loan amount must be between UGX 5,000,000 and UGX 500,000,000.';
                    }
                    break;
                    
                case 'dateOfBirth':
                    if (field.value) {
                        const birthDate = new Date(field.value);
                        const today = new Date();
                        const age = today.getFullYear() - birthDate.getFullYear();
                        if (age < 18 || age > 100) {
                            isValid = false;
                            errorMessage = 'Age must be between 18 and 100 years.';
                        }
                    }
                    break;
                    
                case 'farmSize':
                    if (field.value && (parseFloat(field.value) <= 0 || parseFloat(field.value) > 10000)) {
                        isValid = false;
                        errorMessage = 'Farm size must be between 0.1 and 10,000 acres.';
                    }
                    break;
            }

            if (!isValid) {
                field.classList.add('error');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = errorMessage;
                errorDiv.style.color = '#dc3545';
                errorDiv.style.fontSize = '0.875rem';
                errorDiv.style.marginTop = '0.25rem';
                field.parentNode.insertBefore(errorDiv, field.nextSibling);
            }

            return isValid;
        }

        // Enhanced form submission with validation
        // form.addEventListener('submit', function(e) {
        //     e.preventDefault();
            
        //     let isFormValid = true;
        //     inputs.forEach(input => {
        //         if (!validateField(input)) {
        //             isFormValid = false;
        //         }
        //     });

        //     if (isFormValid) {
        //         // Simulate form processing
        //         const submitButton = form.querySelector('button[type="submit"]');
        //         const originalText = submitButton.textContent;
                
        //         submitButton.disabled = true;
        //         submitButton.textContent = 'Processing Application...';
        //         submitButton.style.background = '#ccc';
                
        //         setTimeout(() => {
        //             // Show success message
        //             const successMessage = document.getElementById('successMessage');
        //             successMessage.style.display = 'block';
                    
        //             // Scroll to success message
        //             successMessage.scrollIntoView({
        //                 behavior: 'smooth',
        //                 block: 'center'
        //             });
                    
        //             // Reset form and button
        //             form.reset();
        //             submitButton.disabled = false;
        //             submitButton.textContent = originalText;
        //             submitButton.style.background = '';
                    
        //             // Hide success message after 10 seconds
        //             setTimeout(() => {
        //                 successMessage.style.display = 'none';
        //             }, 10000);
        //         }, 2000);
        //     } else {
        //         // Scroll to first error
        //         const firstError = form.querySelector('.error');
        //         if (firstError) {
        //             firstError.scrollIntoView({
        //                 behavior: 'smooth',
        //                 block: 'center'
        //             });
        //         }
        //     }
        // });

        // Auto-format phone number
        document.getElementById('phoneNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('256')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+256' + value.substring(1);
            } else if (!value.startsWith('+256') && value.length > 0) {
                value = '+256' + value;
            }
            e.target.value = value;
        });

        // Dynamic loan amount formatting
        document.getElementById('loanAmount').addEventListener('input', function(e) {
            
        });

        // Dynamic monthly income formatting
        document.getElementById('monthlyIncome').addEventListener('input', function(e) {
            const value = e.target.value.replace(/,/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString();
            }
        });

        // Show/hide other crop input
        document.getElementById('primaryCrop').addEventListener('change', function(e) {
            const otherCropGroup = document.getElementById('otherCropGroup');
            if (otherCropGroup) {
                otherCropGroup.remove();
            }
            
            if (e.target.value === 'other') {
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';
                formGroup.id = 'otherCropGroup';
                
                const label = document.createElement('label');
                label.textContent = 'Please specify other crop:';
                label.setAttribute('for', 'otherCrop');
                
                const input = document.createElement('input');
                input.type = 'text';
                input.id = 'otherCrop';
                input.name = 'otherCrop';
                input.required = true;
                
                formGroup.appendChild(label);
                formGroup.appendChild(input);
                e.target.parentNode.parentNode.appendChild(formGroup);
            }
        });

        // Add loading state to buttons on hover
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                }
            });
            
            btn.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(0) scale(1)';
                }
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
@endpush