<div x-data="icpBuilder()" x-init="init()" x-cloak class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">ICP builder</p>
            <h2 class="text-lg font-semibold text-gray-900">Guided ICP wizard with deterministic outbound outputs</h2>
        </div>
        <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs text-blue-900">
            Frontend-only tool (no server processing)
        </div>
    </div>

    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
        <p class="font-semibold">What is an ICP?</p>
        <p class="mt-1 text-blue-800">
            <strong>ICP</strong> means <strong>Ideal Customer Profile</strong> - a clear definition of the accounts and buyer roles most likely to buy, get value, and respond to your outreach.
            This builder helps you turn that into practical targeting rules, scoring, and execution steps.
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-3 flex flex-wrap items-center gap-2 text-xs">
            <template x-for="(stepLabel, i) in steps" :key="stepLabel">
                <button type="button" @click="currentStep = i" class="rounded-full border px-2.5 py-1 font-medium"
                    :class="currentStep === i ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-gray-200 text-gray-600 hover:bg-gray-50'"
                    x-text="(i + 1) + '. ' + stepLabel"></button>
            </template>
        </div>

        <div x-show="currentStep === 0" class="grid gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-gray-700">ICP version name</span>
                <input x-model="icp.versionName" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="e.g. B2B SaaS Security v1" />
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Motion preset</span>
                <select x-model="selectedPreset" @change="applyPreset(selectedPreset)" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Custom</option>
                    <option value="b2b-saas">B2B SaaS</option>
                    <option value="agency">Agency</option>
                    <option value="smb">SMB product-led</option>
                    <option value="enterprise">Enterprise account-based</option>
                </select>
            </label>
            <label class="block sm:col-span-2">
                <span class="text-sm font-medium text-gray-700">Target industries (comma separated)</span>
                <input x-model="icp.industries" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="SaaS, FinTech, Cybersecurity" />
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Company size range</span>
                <input x-model="icp.companySize" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="50-500 employees" />
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Geography</span>
                <input x-model="icp.geography" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="UK + Ireland" />
            </label>
        </div>

        <div x-show="currentStep === 1" class="space-y-3">
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Buyer personas (one per line)</span>
                <textarea x-model="icp.personasRaw" rows="5" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Head of Sales&#10;VP Revenue&#10;Sales Operations Director"></textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Trigger events (one per line)</span>
                <textarea x-model="icp.triggersRaw" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Recent funding&#10;New VP Sales hire&#10;Security incident"></textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Role title include list (comma separated)</span>
                <input x-model="icp.titleInclude" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="VP Sales, CRO, Head of Revenue" />
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Role title exclude list (comma separated)</span>
                <input x-model="icp.titleExclude" type="text" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Recruiter, Intern, Student, SDR" />
            </label>
        </div>

        <div x-show="currentStep === 2" class="grid gap-3 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Must-have criteria (one per line)</span>
                <textarea x-model="icp.mustHaveRaw" rows="6" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Has dedicated sales team&#10;B2B model&#10;Uses CRM"></textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-gray-700">Nice-to-have criteria (one per line)</span>
                <textarea x-model="icp.niceToHaveRaw" rows="6" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Recently expanded to US&#10;Hiring SDRs"></textarea>
            </label>
            <label class="block sm:col-span-2">
                <span class="text-sm font-medium text-gray-700">Negative ICP rules (do not target)</span>
                <textarea x-model="icp.negativeRulesRaw" rows="4" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="No outbound team&#10;Pre-revenue startups&#10;Heavily regulated public sector if no compliance fit"></textarea>
            </label>
        </div>

        <div x-show="currentStep === 3" class="space-y-3">
            <p class="text-sm font-medium text-gray-700">Pain-to-persona mapping</p>
            <template x-for="(row, idx) in painRows" :key="idx">
                <div class="grid gap-2 rounded-lg border border-gray-200 p-3 sm:grid-cols-5">
                    <input x-model="row.persona" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Persona" />
                    <input x-model="row.pain" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Top pain" />
                    <input x-model="row.urgency" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Urgency (high/med/low)" />
                    <input x-model="row.impact" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Measurable impact" />
                    <div class="flex gap-2">
                        <input x-model="row.objection" class="w-full rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Likely objection" />
                        <button type="button" @click="removePainRow(idx)" class="rounded border border-red-200 px-2 text-xs text-red-700">X</button>
                    </div>
                </div>
            </template>
            <button type="button" @click="addPainRow()" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Add mapping row</button>
        </div>

        <div x-show="currentStep === 4" class="space-y-3">
            <p class="text-sm font-medium text-gray-700">Weighted ICP scoring model (must total 100)</p>
            <div class="grid gap-2 sm:grid-cols-5">
                <label class="block"><span class="text-xs text-gray-600">Industry</span><input x-model.number="weights.industry" type="number" min="0" max="100" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-sm" /></label>
                <label class="block"><span class="text-xs text-gray-600">Company size</span><input x-model.number="weights.size" type="number" min="0" max="100" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-sm" /></label>
                <label class="block"><span class="text-xs text-gray-600">Geography</span><input x-model.number="weights.geo" type="number" min="0" max="100" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-sm" /></label>
                <label class="block"><span class="text-xs text-gray-600">Persona fit</span><input x-model.number="weights.persona" type="number" min="0" max="100" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-sm" /></label>
                <label class="block"><span class="text-xs text-gray-600">Trigger fit</span><input x-model.number="weights.trigger" type="number" min="0" max="100" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5 text-sm" /></label>
            </div>
            <p class="text-xs" :class="weightTotal() === 100 ? 'text-green-700' : 'text-amber-700'" x-text="'Current weight total: ' + weightTotal()"></p>
        </div>

        <div class="mt-4 flex items-center justify-between border-t border-dashed border-gray-200 pt-3">
            <button type="button" @click="currentStep = Math.max(0, currentStep - 1)" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700">Back</button>
            <button type="button" @click="currentStep = Math.min(steps.length - 1, currentStep + 1)" class="rounded-lg border border-primary-700 bg-primary-600 px-3 py-2 text-sm font-semibold text-white">Next</button>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">Validation guardrails</h3>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-gray-700">
                <template x-for="item in validationMessages()" :key="item">
                    <li x-text="item"></li>
                </template>
            </ul>
            <p class="mt-3 text-sm"><span class="font-medium">Confidence:</span> <span x-text="confidenceScore() + '/100'"></span></p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">Trigger urgency tiers</h3>
            <template x-for="(row, idx) in triggerPriorityRows" :key="idx">
                <div class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-12">
                    <input x-model="row.trigger" class="sm:col-span-6 rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Trigger" />
                    <select x-model="row.tier" class="sm:col-span-4 rounded border border-gray-300 px-2 py-1.5 text-sm">
                        <option>Critical</option>
                        <option>High</option>
                        <option>Medium</option>
                        <option>Low</option>
                    </select>
                    <button type="button" @click="triggerPriorityRows.splice(idx, 1)" class="sm:col-span-2 rounded border border-gray-300 bg-white px-2 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">Remove</button>
                </div>
            </template>
            <button type="button" @click="triggerPriorityRows.push({ trigger: '', tier: 'High' })" class="mt-3 rounded border border-gray-300 px-2 py-1.5 text-xs font-medium text-gray-700">Add trigger tier</button>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">TAM-lite estimator</h3>
            <p class="mt-2 text-sm text-gray-700">Estimated accounts: <span class="font-semibold" x-text="tamEstimate().accounts"></span></p>
            <p class="text-sm text-gray-700">Estimated contacts: <span class="font-semibold" x-text="tamEstimate().contacts"></span></p>
            <p class="mt-2 text-xs text-gray-500">Rule-based estimate using size/geography/persona constraints.</p>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm space-y-4">
        <h3 class="text-sm font-semibold text-gray-900">Account scoring input (0-100 fit + band)</h3>
        <div class="grid gap-3 sm:grid-cols-5">
            <input x-model="accountInput.industry" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Industry" />
            <input x-model="accountInput.size" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Company size" />
            <input x-model="accountInput.geo" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Geography" />
            <input x-model="accountInput.persona" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Persona" />
            <input x-model="accountInput.trigger" class="rounded border border-gray-300 px-2 py-1.5 text-sm" placeholder="Trigger" />
        </div>
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm text-gray-800">
            <p>Fit score: <span class="font-semibold" x-text="scoreAccount().score"></span> / 100</p>
            <p>Band: <span class="font-semibold" x-text="scoreAccount().band"></span></p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">Outbound query builder</h3>
            <textarea readonly rows="7" class="mt-2 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-xs" x-text="queryBlocks().linkedin"></textarea>
            <textarea readonly rows="7" class="mt-2 w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-xs" x-text="queryBlocks().boolean"></textarea>
            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                <a :href="queryBlocks().linkedInUrl" target="_blank" class="rounded border border-primary-200 px-2 py-1 text-primary-700">Open LinkedIn search</a>
                <button type="button" @click="copyText(queryBlocks().boolean)" class="rounded border border-gray-300 px-2 py-1 text-gray-700" x-text="copyState.boolean ? 'Copied!' : 'Copy boolean block'"></button>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">Messaging angle matrix (persona x pain x proof x CTA)</h3>
            <div class="mt-2 max-h-64 overflow-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-xs">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-2 py-1">Persona</th>
                            <th class="px-2 py-1">Pain</th>
                            <th class="px-2 py-1">Proof</th>
                            <th class="px-2 py-1">CTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in messagingMatrix()" :key="idx">
                            <tr class="border-t border-gray-100">
                                <td class="px-2 py-1" x-text="row.persona"></td>
                                <td class="px-2 py-1" x-text="row.pain"></td>
                                <td class="px-2 py-1" x-text="row.proof"></td>
                                <td class="px-2 py-1" x-text="row.cta"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">30-day outbound test planner</h3>
            <div class="mt-2 grid gap-2 sm:grid-cols-2 text-sm">
                <label>Accounts/week <input x-model.number="plan.accountsPerWeek" type="number" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5" /></label>
                <label>Contacts/account <input x-model.number="plan.contactsPerAccount" type="number" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5" /></label>
                <label>Touches/cadence <input x-model="plan.touchesCadence" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5" /></label>
                <label>Core metric <input x-model="plan.metric" class="mt-1 w-full rounded border border-gray-300 px-2 py-1.5" /></label>
            </div>
            <p class="mt-2 text-sm text-gray-700" x-text="planSummary()"></p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900">Prospecting checklist</h3>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-gray-700">
                <template x-for="item in checklist()" :key="item"><li x-text="item"></li></template>
            </ul>
            <button type="button" @click="downloadCsvSchema()" class="mt-3 rounded border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700">Export CSV starter schema</button>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm space-y-3">
        <h3 class="text-sm font-semibold text-gray-900">Copyable ICP one-pager</h3>
        <textarea readonly rows="14" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-xs" x-text="onePager()"></textarea>
        <div class="flex flex-wrap gap-2">
            <button type="button" @click="copyText(onePager(), 'onePager')" class="rounded border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700" x-text="copyState.onePager ? 'Copied!' : 'Copy one-pager'"></button>
            <button type="button" @click="window.print()" class="rounded border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700">Print-friendly brief</button>
            <button type="button" @click="saveSnapshot()" class="rounded border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700">Save version snapshot</button>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm space-y-2">
        <h3 class="text-sm font-semibold text-gray-900">Version snapshots + performance by version</h3>
        <p class="text-xs text-gray-500">Stored locally in your browser. Backend persistence can be layered later.</p>
        <div class="grid gap-2 sm:grid-cols-4 text-xs">
            <input x-model="perf.version" class="rounded border border-gray-300 px-2 py-1.5" placeholder="Version name" />
            <input x-model.number="perf.replies" type="number" class="rounded border border-gray-300 px-2 py-1.5" placeholder="Replies" />
            <input x-model.number="perf.meetings" type="number" class="rounded border border-gray-300 px-2 py-1.5" placeholder="Meetings" />
            <button type="button" @click="addPerformanceRow()" class="rounded border border-gray-300 px-2 py-1.5 font-medium text-gray-700">Log outcome row</button>
        </div>
        <template x-for="(row, idx) in performanceRows" :key="idx">
            <div class="rounded border border-gray-200 bg-gray-50 p-2 text-xs text-gray-700">
                <span x-text="row.version"></span> - replies: <span x-text="row.replies"></span>, meetings: <span x-text="row.meetings"></span>
            </div>
        </template>
    </div>

    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
        <p class="font-medium">Validation tip</p>
        <p class="mt-1 text-blue-800">Aim for 2-4 industries, 2-6 personas, and a negative rule set. Too broad wastes touches; too narrow starves pipeline.</p>
    </div>

    @push('scripts')
    <script>
        function icpBuilder() {
            const LS_KEY = 'urlcv-icp-builder-snapshots-v1';
            const LS_PERF_KEY = 'urlcv-icp-builder-performance-v1';

            return {
                steps: ['Core profile', 'Personas + triggers', 'Criteria + exclusions', 'Pain mapping', 'Scoring weights'],
                currentStep: 0,
                selectedPreset: '',
                copyState: { onePager: false, boolean: false },
                icp: {
                    versionName: 'ICP v1',
                    industries: '',
                    companySize: '',
                    geography: '',
                    personasRaw: '',
                    triggersRaw: '',
                    titleInclude: '',
                    titleExclude: '',
                    mustHaveRaw: '',
                    niceToHaveRaw: '',
                    negativeRulesRaw: ''
                },
                weights: { industry: 30, size: 20, geo: 15, persona: 20, trigger: 15 },
                accountInput: { industry: '', size: '', geo: '', persona: '', trigger: '' },
                painRows: [{ persona: '', pain: '', urgency: '', impact: '', objection: '' }],
                triggerPriorityRows: [{ trigger: '', tier: 'High' }],
                plan: { accountsPerWeek: 50, contactsPerAccount: 3, touchesCadence: '6 touches / 21 days', metric: 'Positive reply rate' },
                snapshots: [],
                perf: { version: '', replies: 0, meetings: 0 },
                performanceRows: [],

                init() {
                    try {
                        this.snapshots = JSON.parse(localStorage.getItem(LS_KEY) || '[]');
                        this.performanceRows = JSON.parse(localStorage.getItem(LS_PERF_KEY) || '[]');
                    } catch (e) {
                        this.snapshots = [];
                        this.performanceRows = [];
                    }
                },
                lines(v) {
                    return (v || '').split('\n').map((x) => x.trim()).filter(Boolean);
                },
                csv(v) {
                    return (v || '').split(',').map((x) => x.trim()).filter(Boolean);
                },
                addPainRow() {
                    this.painRows.push({ persona: '', pain: '', urgency: '', impact: '', objection: '' });
                },
                removePainRow(idx) {
                    this.painRows.splice(idx, 1);
                    if (!this.painRows.length) this.addPainRow();
                },
                weightTotal() {
                    return Number(this.weights.industry || 0) + Number(this.weights.size || 0) + Number(this.weights.geo || 0) + Number(this.weights.persona || 0) + Number(this.weights.trigger || 0);
                },
                containsAny(value, list) {
                    const source = (value || '').toLowerCase();
                    return list.some((x) => source.includes(x.toLowerCase()));
                },
                scoreAccount() {
                    const industries = this.csv(this.icp.industries);
                    const personas = this.lines(this.icp.personasRaw);
                    const triggers = this.lines(this.icp.triggersRaw);

                    const industryHit = industries.length ? (this.containsAny(this.accountInput.industry, industries) ? 1 : 0) : 0;
                    const sizeHit = this.icp.companySize ? ((this.accountInput.size || '').toLowerCase().includes((this.icp.companySize || '').toLowerCase()) ? 1 : 0) : 0;
                    const geoHit = this.icp.geography ? ((this.accountInput.geo || '').toLowerCase().includes((this.icp.geography || '').toLowerCase()) ? 1 : 0) : 0;
                    const personaHit = personas.length ? (this.containsAny(this.accountInput.persona, personas) ? 1 : 0) : 0;
                    const triggerHit = triggers.length ? (this.containsAny(this.accountInput.trigger, triggers) ? 1 : 0) : 0;

                    const score = Math.round(
                        industryHit * Number(this.weights.industry || 0) +
                        sizeHit * Number(this.weights.size || 0) +
                        geoHit * Number(this.weights.geo || 0) +
                        personaHit * Number(this.weights.persona || 0) +
                        triggerHit * Number(this.weights.trigger || 0)
                    );

                    let band = 'Ignore';
                    if (score >= 75) band = 'High-priority';
                    else if (score >= 45) band = 'Test';

                    return { score, band };
                },
                validationMessages() {
                    const messages = [];
                    const industries = this.csv(this.icp.industries);
                    const personas = this.lines(this.icp.personasRaw);
                    const mustHaves = this.lines(this.icp.mustHaveRaw);
                    if (!this.icp.industries || !this.icp.companySize || !this.icp.geography || !personas.length) {
                        messages.push('Required ICP fields missing: industry, size, geography, and at least one persona.');
                    }
                    if (industries.length > 6 || personas.length > 10) {
                        messages.push('ICP may be too broad. Reduce industry or persona spread.');
                    }
                    if (industries.length <= 1 && personas.length <= 1 && mustHaves.length >= 5) {
                        messages.push('ICP may be too narrow. Expand one dimension for test volume.');
                    }
                    if (!this.lines(this.icp.negativeRulesRaw).length) {
                        messages.push('Add negative ICP rules to reduce wasted outreach.');
                    }
                    if (this.weightTotal() !== 100) {
                        messages.push('Scoring weights should total 100 for consistent account ranking.');
                    }
                    if (!messages.length) messages.push('Looks balanced. Ready for outbound testing.');
                    return messages;
                },
                confidenceScore() {
                    let score = 0;
                    if (this.icp.industries) score += 20;
                    if (this.icp.companySize) score += 15;
                    if (this.icp.geography) score += 15;
                    if (this.lines(this.icp.personasRaw).length) score += 20;
                    if (this.lines(this.icp.mustHaveRaw).length) score += 15;
                    if (this.lines(this.icp.negativeRulesRaw).length) score += 15;
                    return score;
                },
                tamEstimate() {
                    const industries = Math.max(1, this.csv(this.icp.industries).length);
                    const personas = Math.max(1, this.lines(this.icp.personasRaw).length);
                    const geos = Math.max(1, this.csv(this.icp.geography).length);
                    const narrowPenalty = Math.max(0.35, 1 - (this.lines(this.icp.mustHaveRaw).length * 0.06));
                    const accounts = Math.round(industries * geos * 600 * narrowPenalty);
                    const contacts = Math.round(accounts * Math.min(6, personas));
                    return { accounts, contacts };
                },
                queryBlocks() {
                    const industries = this.csv(this.icp.industries);
                    const personas = this.lines(this.icp.personasRaw);
                    const includes = this.csv(this.icp.titleInclude);
                    const excludes = this.csv(this.icp.titleExclude);
                    const geo = this.icp.geography || '';
                    const industryBlock = industries.length ? '(' + industries.map((x) => '"' + x + '"').join(' OR ') + ')' : '';
                    const personaBlock = personas.length ? '(' + personas.map((x) => '"' + x + '"').join(' OR ') + ')' : '';
                    const titleInc = includes.length ? '(' + includes.map((x) => '"' + x + '"').join(' OR ') + ')' : '';
                    const titleExc = excludes.length ? ' NOT (' + excludes.map((x) => '"' + x + '"').join(' OR ') + ')' : '';
                    const linkedin = [
                        'LinkedIn / Sales Nav deterministic block:',
                        'Industry: ' + (industryBlock || 'Any'),
                        'Geography: ' + (geo || 'Any'),
                        'Persona/Role: ' + (personaBlock || titleInc || 'Any'),
                        'Exclude titles: ' + (excludes.join(', ') || 'None')
                    ].join('\n');
                    const boolean = [industryBlock, personaBlock || titleInc, geo ? '"' + geo + '"' : '', titleExc].filter(Boolean).join(' AND ').trim();
                    const linkedInUrl = 'https://www.linkedin.com/search/results/people/?keywords=' + encodeURIComponent(boolean || 'B2B');
                    return { linkedin, boolean, linkedInUrl };
                },
                messagingMatrix() {
                    const rows = this.painRows.filter((x) => x.persona || x.pain);
                    const out = rows.map((r) => ({
                        persona: r.persona || 'Persona',
                        pain: r.pain || 'Pain',
                        proof: r.impact ? 'Measured impact: ' + r.impact : 'Proof: similar customer outcome',
                        cta: r.urgency && r.urgency.toLowerCase().includes('high') ? 'CTA: 15-min priority triage call' : 'CTA: 15-min diagnostic call'
                    }));
                    return out.slice(0, 40);
                },
                planSummary() {
                    const weeklyContacts = Number(this.plan.accountsPerWeek || 0) * Number(this.plan.contactsPerAccount || 0);
                    const monthlyContacts = weeklyContacts * 4;
                    return 'Plan targets ' + this.plan.accountsPerWeek + ' accounts/week and about ' + monthlyContacts + ' contacts in 30 days. Cadence: ' + this.plan.touchesCadence + '. Track: ' + this.plan.metric + '.';
                },
                checklist() {
                    return [
                        'Confirm must-have filters are represented in list source fields.',
                        'Apply negative ICP exclusions before enrichment.',
                        'Prioritise trigger events by urgency tier.',
                        'Build include/exclude title lists and QA 20 sample contacts.',
                        'Assign messaging angle per contact and log angle in outreach tracker.',
                        'Review weekly: score band performance and update ICP version.'
                    ];
                },
                onePager() {
                    const musts = this.lines(this.icp.mustHaveRaw).map((x) => '- ' + x).join('\n') || '- (none)';
                    const nices = this.lines(this.icp.niceToHaveRaw).map((x) => '- ' + x).join('\n') || '- (none)';
                    const neg = this.lines(this.icp.negativeRulesRaw).map((x) => '- ' + x).join('\n') || '- (none)';
                    const triggers = this.lines(this.icp.triggersRaw).map((x) => '- ' + x).join('\n') || '- (none)';
                    return [
                        '# ' + (this.icp.versionName || 'ICP version'),
                        '',
                        '## Positive ICP rules',
                        '- Industries: ' + (this.icp.industries || '(not set)'),
                        '- Company size: ' + (this.icp.companySize || '(not set)'),
                        '- Geography: ' + (this.icp.geography || '(not set)'),
                        '- Personas: ' + (this.lines(this.icp.personasRaw).join(', ') || '(not set)'),
                        '',
                        '## Must-have criteria',
                        musts,
                        '',
                        '## Nice-to-have criteria',
                        nices,
                        '',
                        '## Negative ICP rules',
                        neg,
                        '',
                        '## Trigger events',
                        triggers,
                        '',
                        '## Scoring weights',
                        '- Industry: ' + this.weights.industry + '%',
                        '- Company size: ' + this.weights.size + '%',
                        '- Geography: ' + this.weights.geo + '%',
                        '- Persona fit: ' + this.weights.persona + '%',
                        '- Trigger fit: ' + this.weights.trigger + '%',
                        '',
                        '## Confidence',
                        '- ' + this.confidenceScore() + '/100'
                    ].join('\n');
                },
                async copyText(text, key = 'boolean') {
                    try {
                        await navigator.clipboard.writeText(text);
                        this.copyState[key] = true;
                        setTimeout(() => { this.copyState[key] = false; }, 2000);
                    } catch (e) {}
                },
                downloadCsvSchema() {
                    const headers = ['account', 'domain', 'industry', 'employee_count', 'role', 'seniority', 'icp_score', 'fit_band', 'trigger_event', 'trigger_tier', 'message_angle', 'touch_number', 'response', 'meeting_booked', 'outcome', 'icp_version'];
                    const blob = new Blob([headers.join(',') + '\n'], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'icp-starter-schema.csv';
                    a.click();
                    URL.revokeObjectURL(url);
                },
                saveSnapshot() {
                    const entry = {
                        at: new Date().toISOString(),
                        versionName: this.icp.versionName || 'ICP snapshot',
                        confidence: this.confidenceScore(),
                        payload: {
                            icp: this.icp,
                            weights: this.weights,
                            painRows: this.painRows,
                            triggerPriorityRows: this.triggerPriorityRows
                        }
                    };
                    this.snapshots.unshift(entry);
                    this.snapshots = this.snapshots.slice(0, 20);
                    localStorage.setItem(LS_KEY, JSON.stringify(this.snapshots));
                },
                addPerformanceRow() {
                    if (!this.perf.version) return;
                    this.performanceRows.unshift({
                        version: this.perf.version,
                        replies: Number(this.perf.replies || 0),
                        meetings: Number(this.perf.meetings || 0),
                        at: new Date().toISOString()
                    });
                    this.performanceRows = this.performanceRows.slice(0, 50);
                    localStorage.setItem(LS_PERF_KEY, JSON.stringify(this.performanceRows));
                    this.perf = { version: '', replies: 0, meetings: 0 };
                },
                applyPreset(key) {
                    if (!key) return;
                    const presets = {
                        'b2b-saas': {
                            industries: 'B2B SaaS, FinTech, Cybersecurity',
                            companySize: '50-1000 employees',
                            geography: 'UK, Ireland, DACH',
                            personasRaw: 'VP Sales\nHead of Revenue Operations\nCRO',
                            triggersRaw: 'Recent funding\nNew VP Sales hire\nRapid hiring',
                            mustHaveRaw: 'B2B sales team\nOwns CRM process\nMulti-person buying committee',
                            negativeRulesRaw: 'No outbound motion\nConsumer-only product'
                        },
                        'agency': {
                            industries: 'Marketing agency, Creative agency, Performance agency',
                            companySize: '10-200 employees',
                            geography: 'UK, US',
                            personasRaw: 'Agency Founder\nHead of Growth\nClient Services Director',
                            triggersRaw: 'Client churn spike\nNew service line launch',
                            mustHaveRaw: 'Retainer model\nOutbound or partnerships motion',
                            negativeRulesRaw: 'One-person freelancer only'
                        },
                        'smb': {
                            industries: 'Ecommerce, Services, SaaS',
                            companySize: '10-100 employees',
                            geography: 'US, UK, Canada',
                            personasRaw: 'Founder\nHead of Sales',
                            triggersRaw: 'First sales hire\nEntering new market',
                            mustHaveRaw: 'Active pipeline\nDefined ICP owner',
                            negativeRulesRaw: 'No budget owner identified'
                        },
                        'enterprise': {
                            industries: 'Enterprise software, Financial services, Healthcare tech',
                            companySize: '1000+ employees',
                            geography: 'North America, EMEA',
                            personasRaw: 'SVP Sales\nVP GTM Strategy\nDirector Procurement',
                            triggersRaw: 'Regulatory update\nSecurity breach\nM&A event',
                            mustHaveRaw: 'Cross-functional buying committee\nCompliance budget',
                            negativeRulesRaw: 'Single-threaded champion only'
                        }
                    };
                    const p = presets[key];
                    if (!p) return;
                    this.icp.industries = p.industries;
                    this.icp.companySize = p.companySize;
                    this.icp.geography = p.geography;
                    this.icp.personasRaw = p.personasRaw;
                    this.icp.triggersRaw = p.triggersRaw;
                    this.icp.mustHaveRaw = p.mustHaveRaw;
                    this.icp.negativeRulesRaw = p.negativeRulesRaw;
                }
            };
        }
    </script>
    @endpush

    @push('styles')
    <style>
        @media print {
            header, nav, footer, .tool-sidebar, button, a {
                display: none !important;
            }
            body {
                background: #fff !important;
            }
            textarea {
                border: 1px solid #ddd !important;
            }
        }
    </style>
    @endpush
</div>
