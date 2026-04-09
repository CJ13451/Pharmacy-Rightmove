<x-layouts.app title="Pharmacy Valuations">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Pharmacy Valuations</h1>
            <p class="text-gray-300">Get an indicative valuation for your pharmacy business.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Free Indicative Valuation</h2>
                    <p class="text-gray-600 max-w-lg mx-auto">Enter your pharmacy details below to receive an instant indicative valuation based on current market conditions.</p>
                </div>

                <form 
                    x-data="valuationCalculator()"
                    @submit.prevent="calculate"
                    class="space-y-6"
                >
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly NHS Items</label>
                            <input 
                                type="number" 
                                x-model="monthlyItems"
                                required
                                min="0"
                                placeholder="e.g. 8000"
                                class="w-full rounded-lg border-gray-300"
                            >
                            <p class="text-xs text-gray-500 mt-1">Average monthly prescription items</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Annual Turnover</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input 
                                    type="number" 
                                    x-model="annualTurnover"
                                    required
                                    min="0"
                                    placeholder="e.g. 1200000"
                                    class="w-full rounded-lg border-gray-300 pl-7"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Annual Gross Profit</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input 
                                    type="number" 
                                    x-model="grossProfit"
                                    required
                                    min="0"
                                    placeholder="e.g. 350000"
                                    class="w-full rounded-lg border-gray-300 pl-7"
                                >
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                            <select x-model="propertyType" required class="w-full rounded-lg border-gray-300">
                                <option value="">Select...</option>
                                <option value="freehold">Freehold</option>
                                <option value="leasehold">Leasehold</option>
                            </select>
                        </div>

                        <div x-show="propertyType === 'leasehold'">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lease Years Remaining</label>
                            <input 
                                type="number" 
                                x-model="leaseYears"
                                min="0"
                                max="100"
                                placeholder="e.g. 15"
                                class="w-full rounded-lg border-gray-300"
                            >
                        </div>

                        <div x-show="propertyType === 'leasehold'">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Annual Rent</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input 
                                    type="number" 
                                    x-model="annualRent"
                                    min="0"
                                    placeholder="e.g. 25000"
                                    class="w-full rounded-lg border-gray-300 pl-7"
                                >
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                        <select x-model="region" required class="w-full rounded-lg border-gray-300">
                            <option value="">Select region...</option>
                            @foreach(\App\Enums\Region::cases() as $region)
                                <option value="{{ $region->value }}">{{ $region->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" x-model="hasAccommodation" class="rounded border-gray-300 text-green-600">
                            <span class="text-sm text-gray-700">Includes accommodation above</span>
                        </label>
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition"
                    >
                        Calculate Valuation
                    </button>
                </form>

                <!-- Results -->
                <div x-show="showResults" x-cloak class="mt-8 p-6 bg-green-50 rounded-xl border border-green-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">Indicative Valuation Range</h3>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            £<span x-text="formatNumber(valuationLow)"></span> - £<span x-text="formatNumber(valuationHigh)"></span>
                        </div>
                        <p class="text-gray-600 text-sm">Based on current market conditions</p>
                    </div>

                    <div class="mt-6 grid md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-white rounded-lg p-4 text-center">
                            <p class="text-gray-500">Per Item Value</p>
                            <p class="font-bold text-gray-900">£<span x-text="perItemValue.toFixed(2)"></span></p>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center">
                            <p class="text-gray-500">GP Multiple</p>
                            <p class="font-bold text-gray-900"><span x-text="gpMultiple.toFixed(1)"></span>x</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center">
                            <p class="text-gray-500">Turnover %</p>
                            <p class="font-bold text-gray-900"><span x-text="turnoverPercent.toFixed(0)"></span>%</p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-sm text-amber-800">
                            <strong>Disclaimer:</strong> This is an indicative valuation only and should not be relied upon for formal purposes. 
                            For an accurate valuation, please contact a professional pharmacy valuator or broker.
                        </p>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600 mb-4">Want to discuss your valuation with an expert?</p>
                        <a href="mailto:valuations@p3pharmacy.co.uk" class="inline-block bg-white border border-green-600 text-green-600 hover:bg-green-50 px-6 py-2 rounded-lg font-medium transition">
                            Contact Our Team
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4">What affects pharmacy valuations?</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Monthly prescription items and trends</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Gross profit margins and retail mix</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Property tenure and condition</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Location and local competition</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>NHS contract services and PCN involvement</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4">Need a formal valuation?</h3>
                <p class="text-gray-600 mb-4">
                    For accurate valuations for sale, purchase, or financing purposes, we recommend engaging a professional pharmacy valuator.
                </p>
                <a href="{{ route('resources.index', ['category' => 'buying_selling']) }}" class="text-green-600 hover:text-green-700 font-medium">
                    View our buying & selling guides →
                </a>
            </div>
        </div>
    </div>

    <script>
        function valuationCalculator() {
            return {
                monthlyItems: '',
                annualTurnover: '',
                grossProfit: '',
                propertyType: '',
                leaseYears: '',
                annualRent: '',
                region: '',
                hasAccommodation: false,
                showResults: false,
                valuationLow: 0,
                valuationHigh: 0,
                perItemValue: 0,
                gpMultiple: 0,
                turnoverPercent: 0,

                calculate() {
                    const items = parseFloat(this.monthlyItems) || 0;
                    const turnover = parseFloat(this.annualTurnover) || 0;
                    const gp = parseFloat(this.grossProfit) || 0;
                    const rent = parseFloat(this.annualRent) || 0;

                    // Base per-item value (market dependent)
                    let basePerItem = 22; // £22 per item baseline
                    
                    // Regional adjustments
                    const regionalMultipliers = {
                        'london': 1.15,
                        'south_east': 1.10,
                        'south_west': 1.00,
                        'east_anglia': 0.95,
                        'midlands': 0.95,
                        'north_west': 0.95,
                        'north_east': 0.90,
                        'yorkshire': 0.95,
                        'wales': 0.90,
                        'scotland': 0.90,
                        'northern_ireland': 0.85
                    };

                    const regionMult = regionalMultipliers[this.region] || 1.0;

                    // Freehold premium
                    let tenureMult = this.propertyType === 'freehold' ? 1.15 : 1.0;
                    
                    // Lease adjustment (lower value for short leases)
                    if (this.propertyType === 'leasehold' && this.leaseYears) {
                        const years = parseFloat(this.leaseYears);
                        if (years < 5) tenureMult = 0.7;
                        else if (years < 10) tenureMult = 0.85;
                        else if (years < 15) tenureMult = 0.95;
                    }

                    // Accommodation bonus
                    const accomBonus = this.hasAccommodation ? 50000 : 0;

                    // Calculate item-based valuation
                    const annualItems = items * 12;
                    this.perItemValue = basePerItem * regionMult * tenureMult;
                    const itemValuation = annualItems * this.perItemValue;

                    // Calculate GP multiple (typically 1.5-2.5x)
                    this.gpMultiple = 1.8 * regionMult * tenureMult;
                    const gpValuation = gp * this.gpMultiple;

                    // Deduct rent capitalisation for leasehold
                    let rentDeduction = 0;
                    if (this.propertyType === 'leasehold' && rent > 0) {
                        rentDeduction = rent * 3; // ~3 years rent deduction
                    }

                    // Average of methods
                    const avgValuation = ((itemValuation + gpValuation) / 2) + accomBonus - rentDeduction;

                    // Range (-10% to +15%)
                    this.valuationLow = Math.round(avgValuation * 0.9);
                    this.valuationHigh = Math.round(avgValuation * 1.15);

                    // Turnover percentage
                    this.turnoverPercent = turnover > 0 ? (avgValuation / turnover) * 100 : 0;

                    this.showResults = true;
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('en-GB').format(num);
                }
            }
        }
    </script>
</x-layouts.app>
