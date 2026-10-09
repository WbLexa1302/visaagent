@props(['countries', 'products'])

<section x-data="{ 
    openModal: false, 
    pdfUrl: '', 
    visaName: '',
    openPdfPreview(link, name) {
        if (!link) return;
        let embedLink = link;
        if (link.includes('drive.google.com')) {
            embedLink = link.replace('/view', '/preview').replace('/open?id=', '/file/d/') + '/preview';
            embedLink = embedLink.replace('//preview', '/preview');
        }
        this.pdfUrl = embedLink;
        this.visaName = name;
        this.openModal = true;
    }
}" class="relative -mt-8 z-20 max-w-6xl mx-auto px-6 mb-24">

    <div class="bg-white/95 backdrop-blur-sm p-6 md:p-8 rounded-3xl shadow-2xl border border-gray-100">
        <form id="visaSelectorForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">

            <div class="relative">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nationality</label>
                <div class="relative">
                    <input type="text" id="negaraSearchInput" placeholder="Search country..." autocomplete="off"
                           class="w-full p-4 pr-10 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 transition-all bg-gray-50 cursor-pointer font-medium text-gray-800" required>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4 transition-transform duration-200" id="searchDropdownArrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <input type="hidden" id="kewarganegaraan" name="kewarganegaraan" value="">

                <div id="negaraDropdownMenu" class="absolute z-50 left-0 right-0 mt-2 max-h-60 overflow-y-auto bg-white border border-gray-100 shadow-2xl rounded-2xl hidden scrollbar-thin">
                    @foreach($countries as $country)
                        <div class="negara-option px-4 py-3 hover:bg-teal-50/60 cursor-pointer text-gray-700 font-medium text-sm transition-colors flex items-center justify-between"
                             data-value="{{ $country->code }}"
                             data-name="{{ $country->name }}"
                             data-allow-30="{{ $country->allow_30_days ? '1' : '0' }}">
                            <span>{{ $country->name }}</span>
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-mono">{{ $country->code }}</span>
                        </div>
                    @endforeach
                    <div id="negaraNotFound" class="px-4 py-4 text-center text-sm text-gray-400 hidden">
                        Country not found
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Purpose / Category</label>
                <select id="tujuan" name="tujuan" required class="w-full p-4 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 transition-all bg-gray-50 cursor-pointer font-medium text-gray-800">
                    <option value="" disabled selected>Select Purpose</option>
                    <option value="tourist-visa">Tourist Visa</option>
                    <option value="business-visa">Business Visa</option>
                    <option value="arts-and-cultural-performance">Arts and Cultural Performance</option>
                    <option value="event-participant">Event Participant</option>
                    <option value="pre-investment-visa">Pre-Investment Visa</option>
                    <option value="film-media-production">Film & Media Production</option>
                    <option value="work-trial">Work Trial</option>
                    <option value="machine-installation-repair">Machine Installation & Repair</option>
                    <option value="internship-visa">Internship Visa</option>
                    <option value="retirement-and-silver-hair">Retirement and Silver Hair</option>
                    <option value="remote-worker">Remote Worker</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Visa Type</label>
                <select id="tipe_visa" name="tipe_visa" required class="w-full p-4 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 transition-all bg-gray-50 cursor-pointer font-medium text-gray-800">
                    <option value="" disabled selected>Select Type</option>
                    <option value="single_entry">Single Entry</option>
                    <option value="multiple_entry">Multiple Entry</option>
                    <option value="kitas">KITAS / Limited Stay</option>
                    <option value="kitap">KITAP</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Stay Duration</label>
                <select id="durasi" name="durasi" required class="w-full p-4 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 transition-all bg-gray-50 cursor-pointer font-medium text-gray-800">
                    <option value="" disabled selected>Select Duration</option>
                    <option id="opsi-30" value="30">30 Days</option>
                    <option value="60">60 Days</option>
                    <option value="180">180 Days</option>
                    <option value="365">1 Year (365 Days)</option>
                    <option value="730">2 Years (730 Days)</option>
                </select>
            </div>

        </form>
    </div>

    <div id="visaResultsContainer" class="mt-8 space-y-6 hidden">
        @foreach($products as $product)
            @php
                $categorySlug = $product->category->slug ?? '';
                $duration = $product->duration ?? '60';
                $visaType = $product->visa_type ?? 'single_entry';
                $pesanWhatsapp = rawurlencode("Hello Bali Ease, I am interested in the *" . $product->name . "* service. Could you please provide information on the application process?");
                $driveLink = $product->drive_link ?? ''; 
            @endphp

            <div class="visa-card bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 transition-all"
                 data-category-slug="{{ $categorySlug }}"
                 data-visa-type="{{ $visaType }}"
                 data-durasi="{{ $duration }}">

                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">
                    <div class="flex-1 space-y-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <div class="text-gray-600 leading-relaxed text-sm">
                                {!! $product->description ?? 'Perfect visa option for your stay in Indonesia.' !!}
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4">
                            <div class="bg-slate-50 inline-block px-4 py-2 rounded-xl border border-slate-100">
                                <span class="text-xs text-gray-400 block font-medium">Service Fee</span>
                                <span class="text-xl font-bold text-teal-600">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>

                            @if($driveLink)
                                <button type="button" 
                                        @click="openPdfPreview('{{ $driveLink }}', '{{ $product->name }}')"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-200 hover:border-teal-600 text-gray-600 hover:text-teal-600 text-sm font-semibold rounded-xl transition-colors bg-white shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    More Details
                                </button>
                            @endif
                        </div>

                        @if($product->requirements || $product->processing_time)
                        <details class="group border-t border-gray-100 pt-4 cursor-pointer">
                            <summary class="list-none flex items-center justify-between text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors">
                                <span>View Requirements</span>
                                <span class="transition group-open:rotate-180">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </span>
                            </summary>

                            <div class="text-sm text-gray-600 mt-4 p-4 bg-teal-50/30 rounded-2xl space-y-3 leading-relaxed border border-teal-50/50">
                                @if($product->requirements)
                                    <div>
                                        <strong class="text-gray-800 block mb-1">Document Requirements:</strong>
                                        <p class="text-gray-600 whitespace-pre-line">{{ $product->requirements }}</p>
                                    </div>
                                @endif

                                @if($product->processing_time)
                                    <div class="border-t border-gray-100 pt-2 mt-2">
                                        <p><strong class="text-gray-800">Estimated Processing Time:</strong> {{ $product->processing_time }}</p>
                                    </div>
                                @endif
                            </div>
                        </details>
                        @endif
                    </div>

                    <div class="flex items-center min-w-[180px] w-full md:w-auto">
                        <a href="https://wa.me/6281547410870?text={{ $pesanWhatsapp }}"
                           target="_blank" rel="noopener noreferrer"
                           class="w-full text-center py-3.5 px-6 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 shadow-md shadow-teal-600/10 hover:shadow-lg hover:shadow-teal-600/20 transition-all flex items-center justify-center gap-2">
                            Contact Us via WA
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <div id="noVisaMessage" class="hidden text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-gray-500 font-medium">Sorry, there are no visa types matching your criteria.</p>
        </div>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;" @click.self="openModal = false">
        <div class="bg-white w-full max-w-4xl h-[85vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-gray-800 text-lg" x-text="visaName"></h4>
                    <p class="text-xs text-gray-400 font-medium">Document Details & Guidelines</p>
                </div>
                <button type="button" @click="openModal = false" class="p-2 rounded-xl bg-gray-200/50 hover:bg-gray-200 text-gray-500">
                    ✕
                </button>
            </div>
            <div class="flex-1 bg-gray-100">
                <template x-if="openModal">
                    <iframe :src="pdfUrl" class="w-full h-full border-0" allow="autoplay"></iframe>
                </template>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('negaraSearchInput');
    const dropdownMenu = document.getElementById('negaraDropdownMenu');
    const arrowIcon = document.getElementById('searchDropdownArrow');
    const hiddenNegaraInput = document.getElementById('kewarganegaraan');
    const negaraOptions = document.querySelectorAll('.negara-option');
    const negaraNotFound = document.getElementById('negaraNotFound');

    const tujuanSelect = document.getElementById('tujuan');
    const tipeVisaSelect = document.getElementById('tipe_visa');
    const durasiSelect = document.getElementById('durasi');
    const opsi30Hari = document.getElementById('opsi-30');
    const resultsContainer = document.getElementById('visaResultsContainer');
    const visaCards = document.querySelectorAll('.visa-card');
    const noVisaMessage = document.getElementById('noVisaMessage');

    let currentAllow30 = "1";

    searchInput.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
        arrowIcon.classList.toggle('rotate-180');
        if (!dropdownMenu.classList.contains('hidden')) this.select();
    });

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        let matchCount = 0;
        dropdownMenu.classList.remove('hidden');
        arrowIcon.classList.add('rotate-180');

        negaraOptions.forEach(option => {
            const name = option.getAttribute('data-name').toLowerCase();
            const code = option.getAttribute('data-value').toLowerCase();
            if (name.includes(query) || code.includes(query)) {
                option.style.display = 'flex';
                matchCount++;
            } else {
                option.style.display = 'none';
            }
        });
        negaraNotFound.classList.toggle('hidden', matchCount > 0);
    });

    negaraOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.stopPropagation();
            searchInput.value = this.getAttribute('data-name');
            hiddenNegaraInput.value = this.getAttribute('data-value');
            currentAllow30 = this.getAttribute('data-allow-30');

            dropdownMenu.classList.add('hidden');
            arrowIcon.classList.remove('rotate-180');

            if (currentAllow30 === '0') {
                opsi30Hari.style.display = 'none';
                if (durasiSelect.value === '30') durasiSelect.value = '';
            } else {
                opsi30Hari.style.display = 'block';
            }
            filterVisas();
        });
    });

    document.addEventListener('click', function() {
        dropdownMenu.classList.add('hidden');
        arrowIcon.classList.remove('rotate-180');
        if (!hiddenNegaraInput.value) searchInput.value = '';
    });

    tujuanSelect.addEventListener('change', filterVisas);
    tipeVisaSelect.addEventListener('change', filterVisas);
    durasiSelect.addEventListener('change', filterVisas);

    function filterVisas() {
        const tujuanValue = tujuanSelect.value;
        const tipeValue = tipeVisaSelect.value;
        const durasiValue = durasiSelect.value;
        const negaraValue = hiddenNegaraInput.value;

        if (!negaraValue || !tujuanValue || !tipeValue || !durasiValue) {
            resultsContainer.classList.add('hidden');
            return;
        }

        let visibleCardsCount = 0;
        visaCards.forEach(card => {
            const match = (card.getAttribute('data-category-slug') === tujuanValue) &&
                          (card.getAttribute('data-visa-type') === tipeValue) &&
                          (card.getAttribute('data-durasi') === durasiValue);

            card.style.display = match ? 'block' : 'none';
            if(match) visibleCardsCount++;
        });

        resultsContainer.classList.remove('hidden');
        noVisaMessage.classList.toggle('hidden', visibleCardsCount > 0);
    }
});
</script>