<div class="am-insights-wrapper tb-custom-scrollbar">
    <div class="am-insights">
        <div class="am-insights_section am-revenue">
            <div class="am-insights_header">
                <div class="am-insights_title">
                    <h2>{{ __('admin/general.revenue_payment_metrics') }}</h2>
                    <p>{{ __('admin/general.track_manage_income') }}</p>
                </div>
                <div class="am-insights_actions">
                    <em>Filter by:</em>
                    <span class="tb-select">
                        <input type="text" id="revenue-date-range" class="form-control">
                    </span>
                </div>
            </div>
            <div class="am-insights_content">
                <ul class="am-payment_list">
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.8025 9.28079C21.673 9.28079 24 11.6803 24 14.6404C24 17.6004 21.673 20 18.8025 20H4.28025V19.9767C4.21606 19.9838 4.15157 19.9894 4.08648 19.9933C4.01154 19.9978 3.93601 20 3.85987 20C1.72811 20 0 18.218 0 16.0197C0 13.8609 1.6663 12.1036 3.74522 12.0411C3.74522 12.0274 3.74522 12.0137 3.74522 12C3.74522 7.58174 7.21845 4 11.5032 4C14.8621 4 17.7232 6.20112 18.8025 9.28079Z" fill="#B1B0FF"/><path d="M9.51299 14.5793C9.51299 15.4996 10.6402 16.394 11.8386 16.394M11.8386 16.394C13.2703 16.394 14.4299 15.6746 14.4947 14.5728C14.689 11.2546 9.51299 13.309 9.50003 10.25C9.49356 9.14829 10.407 8.3965 11.8322 8.3965C13.0177 8.3965 14.4947 8.97978 14.4947 10.263M11.8386 16.394L11.8382 17.3984M11.8382 8.3965V7.39844" stroke="#8280FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"/></svg>
                            </div>
                            <div class="am-payment_item_info">
                                <h3>{{ formatAmount($this->platformEarnings) }}</h3>
                                <span>{{ __('admin/general.platform_earnings') }}</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M16.6634 5.02774C17.966 5.61967 17.9664 7.46972 16.664 8.06216L10.6895 10.7759C10.2518 10.9745 9.74961 10.9745 9.31187 10.7759L3.33738 8.06216C2.03504 7.46972 2.03541 5.61967 3.33799 5.02775L9.31119 2.31338C9.74931 2.11429 10.2521 2.11429 10.6902 2.31338L16.6634 5.02774Z" fill="#7DD8AE"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 18C24 21.3139 21.3147 24 18 24C15.6897 24 13.6842 22.695 12.683 20.7815C12.2478 19.9503 12 19.0036 12 18C12 17.1529 12.1741 16.3468 12.4922 15.6161C13.4129 13.4883 15.5324 12 18 12C21.3147 12 24 14.6861 24 18ZM17.2132 21.6152C17.2132 22.0078 17.5279 22.2439 17.8426 22.2439C18.2344 22.2439 18.4721 22.0078 18.4721 21.6152V21.4579C19.2589 21.3457 19.8884 20.9498 20.1797 20.3864C20.4542 19.8574 20.4509 19.0831 20.1797 18.5575C19.7846 17.7941 18.8538 17.5639 18.1674 17.3931L18.077 17.3705C17.0558 17.1353 16.7411 16.978 16.7411 16.428C16.7411 15.8664 17.3605 15.642 17.8426 15.642H17.9196C18.4721 15.642 19.2556 15.8772 19.2556 16.428C19.2556 16.7419 19.5703 17.0566 19.885 17.0566C20.1998 17.0566 20.4342 16.7419 20.4342 16.428C20.4342 15.406 19.4933 14.6987 18.4721 14.5413V14.3839C18.4721 13.9914 18.1574 13.7553 17.8426 13.7553C17.5279 13.7553 17.2902 13.9914 17.2902 14.3839V14.5413C16.8214 14.62 16.3493 14.856 16.1116 15.0912C15.9174 15.2863 15.7801 15.5006 15.6931 15.7241C15.6027 15.9517 15.5625 16.1895 15.5625 16.428C15.5625 17.1018 15.8237 17.5446 16.1819 17.8426C16.6607 18.2402 17.3136 18.3817 17.7623 18.4713C18.9408 18.7073 19.1786 18.8647 19.1786 19.4933C19.1786 19.9646 18.6295 20.2793 17.8426 20.2793C17.2902 20.2793 16.7578 19.8859 16.7578 19.572C16.7578 19.2573 16.6004 19.0212 16.2054 19.0212C15.8136 19.0212 15.5792 19.2573 15.5792 19.572C15.5792 20.4367 16.3493 21.2227 17.2132 21.4579V21.6152Z" fill="#17B26A"/><path d="M2.41416 11.0885C1.46734 11.5258 1.47122 12.8729 2.42053 13.3048L8.41554 16.0287M2.41416 16.3407L2.25943 16.4122C1.37329 16.8215 1.37691 18.0822 2.26539 18.4864L8.41554 21.2809M3.33655 8.06216C2.03421 7.46972 2.03458 5.61967 3.33716 5.02775L9.31036 2.31338C9.74848 2.11429 10.2513 2.11429 10.6894 2.31338L16.6626 5.02774C17.9652 5.61967 17.9655 7.46972 16.6632 8.06216L10.6887 10.7759C10.251 10.9745 9.74878 10.9745 9.31104 10.7759L3.33655 8.06216Z" stroke="#17B26A" stroke-width="1.28571" stroke-miterlimit="10" stroke-linecap="round"/></svg>
                            </div>
                            <div class="am-payment_item_info">
                                <h3>{{ formatAmount($this->tutorEarnings) }}</h3>
                                <span>{{ __('admin/general.tutor_payouts') }}</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.25 12C1.25 6.06294 6.06294 1.25 12 1.25C17.9371 1.25 22.75 6.06294 22.75 12C22.75 17.9371 17.9371 22.75 12 22.75C6.06294 22.75 1.25 17.9371 1.25 12Z" fill="#FF976A"/><path d="M16.1238 7.80664L7.87769 16.1946M8.82454 9.67738C9.27996 9.67738 9.64915 9.30184 9.64915 8.83859C9.64915 8.37533 9.27996 7.99979 8.82454 7.99979M8.82454 9.67738C8.36912 9.67738 7.99993 9.30184 7.99993 8.83859C7.99993 8.37533 8.36912 7.99979 8.82454 7.99979M8.82454 9.67738V7.99979M15.1753 15.9998C15.6307 15.9998 15.9999 15.6243 15.9999 15.161C15.9999 14.6977 15.6307 14.3222 15.1753 14.3222M15.1753 15.9998C14.7199 15.9998 14.3507 15.6243 14.3507 15.161C14.3507 14.6977 14.7199 14.3222 15.1753 14.3222M15.1753 15.9998V14.3222" stroke="#FF4C00" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <div class="am-payment_item_info">
                                <h3>{{ formatAmount($this->platformCommission) }}</h3>
                                <span>{{ __('admin/general.platform_commission') }}</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M20 12C20 12.4156 19.9683 12.8237 19.9072 13.2222C19.6811 14.6975 17.7587 12.4153 14.8822 14.0333C12.645 17.549 15.6417 19.3254 14 19.748C13.3608 19.9125 12.6906 20 12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" fill="#8CC2FC"/><path d="M12.0594 8.51953V11.8895L9.85938 14.0895" stroke="#2E90FA" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 18C24 21.3139 21.3147 24 18 24C15.6897 24 13.6842 22.695 12.683 20.7815C12.2478 19.9503 12 19.0036 12 18C12 17.1529 12.1741 16.3468 12.4922 15.6161C13.4129 13.4883 15.5324 12 18 12C21.3147 12 24 14.6861 24 18ZM17.2132 21.6152C17.2132 22.0078 17.5279 22.2439 17.8426 22.2439C18.2344 22.2439 18.4721 22.0078 18.4721 21.6152V21.4579C19.2589 21.3457 19.8884 20.9498 20.1797 20.3864C20.4542 19.8574 20.4509 19.0831 20.1797 18.5575C19.7846 17.7941 18.8538 17.5639 18.1674 17.3931L18.077 17.3705C17.0558 17.1353 16.7411 16.978 16.7411 16.428C16.7411 15.8664 17.3605 15.642 17.8426 15.642H17.9196C18.4721 15.642 19.2556 15.8772 19.2556 16.428C19.2556 16.7419 19.5703 17.0566 19.885 17.0566C20.1998 17.0566 20.4342 16.7419 20.4342 16.428C20.4342 15.406 19.4933 14.6987 18.4721 14.5413V14.3839C18.4721 13.9914 18.1574 13.7553 17.8426 13.7553C17.5279 13.7553 17.2902 13.9914 17.2902 14.3839V14.5413C16.8214 14.62 16.3493 14.856 16.1116 15.0912C15.9174 15.2863 15.7801 15.5006 15.6931 15.7241C15.6027 15.9517 15.5625 16.1895 15.5625 16.428C15.5625 17.1018 15.8237 17.5446 16.1819 17.8426C16.6607 18.2402 17.3136 18.3817 17.7623 18.4713C18.9408 18.7073 19.1786 18.8647 19.1786 19.4933C19.1786 19.9646 18.6295 20.2793 17.8426 20.2793C17.2902 20.2793 16.7578 19.8859 16.7578 19.572C16.7578 19.2573 16.6004 19.0212 16.2054 19.0212C15.8136 19.0212 15.5792 19.2573 15.5792 19.572C15.5792 20.4367 16.3493 21.2227 17.2132 21.4579V21.6152Z" fill="#2E90FA"/></svg>
                            </div>
                            <div class="am-payment_item_info">
                                <h3>{{ formatAmount($this->tutorPendingEarnings) }}</h3>
                                <span>{{ __('admin/general.pending_payouts') }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="am-insights_section am-engagement">
            <div class="am-insights_header">
                <div class="am-insights_title">
                    <h2>{{ __('admin/general.session_engagement') }}</h2>
                    <p>{{ __('admin/general.track_manage_income') }}</p>
                </div>
                <div class="am-insights_actions">
                    <em>Filter by:</em>
                    <span class="tb-select">
                        {{-- <span wire:click="clearSession">clear filters x</span> --}}
                        <input type="text" id="session-date-range" class="form-control">
                    </span>
                </div>
            </div>
            <div class="am-insights_content">
                <ul class="am-payment_list">
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_info">
                                <h3>{{ $this->totalSessions }}</h3>
                                <span>{{ __('admin/general.total_sessions_booked') }}</span>
                            </div>
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none"><rect x="2.8335" y="3.32422" width="23.3333" height="23.3333" rx="4.66667" fill="#7FD2C0"/><rect x="5.48584" y="9.49609" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="13.019" y="9.49609" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="20.5522" y="9.49609" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="5.48584" y="17.3633" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="13.019" y="17.3633" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="20.5522" y="17.3633" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M10.1023 1.3418C10.5855 1.3418 10.9773 1.73355 10.9773 2.2168V4.55013C10.9773 5.03338 10.5855 5.42513 10.1023 5.42513C9.61905 5.42513 9.22729 5.03338 9.22729 4.55013V2.2168C9.22729 1.73355 9.61905 1.3418 10.1023 1.3418Z" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M19.4358 1.3418C19.919 1.3418 20.3108 1.73355 20.3108 2.2168V4.55013C20.3108 5.03338 19.919 5.42513 19.4358 5.42513C18.9525 5.42513 18.5608 5.03338 18.5608 4.55013V2.2168C18.5608 1.73355 18.9525 1.3418 19.4358 1.3418Z" fill="#00AD76"/></svg>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_info">
                                <h3>{{ $this->completedSessions }}</h3>
                                <span>{{ __('admin/general.completed_sessions') }}</span>
                            </div>
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none"><path d="M0.5 11.6283C0.5 7.22848 0.5 5.02859 1.86684 3.66176C3.23367 2.29492 5.43356 2.29492 9.83333 2.29492H14.5C18.8998 2.29492 21.0997 2.29492 22.4665 3.66176C23.8333 5.02859 23.8333 7.22848 23.8333 11.6283V16.2949C23.8333 20.6947 17.6483 19.556 16.2815 20.9229C15.2272 21.9771 19.8623 25.5568 17.1895 25.6119C16.3971 25.6283 15.5061 25.6283 14.5 25.6283H9.83333C5.43356 25.6283 3.23367 25.6283 1.86684 24.2614C0.5 22.8946 0.5 20.6947 0.5 16.2949V11.6283Z" fill="#7FD2C0"/><rect x="2.88354" y="8.27734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="10.4167" y="8.27734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="17.95" y="8.27734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="2.88354" y="16.1445" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="10.4167" y="16.1445" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.125C7.98325 0.125 8.375 0.516751 8.375 1V3.33333C8.375 3.81658 7.98325 4.20833 7.5 4.20833C7.01675 4.20833 6.625 3.81658 6.625 3.33333V1C6.625 0.516751 7.01675 0.125 7.5 0.125Z" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M16.8333 0.125C17.3165 0.125 17.7083 0.516751 17.7083 1V3.33333C17.7083 3.81658 17.3165 4.20833 16.8333 4.20833C16.35 4.20833 15.9583 3.81658 15.9583 3.33333V1C15.9583 0.516751 16.35 0.125 16.8333 0.125Z" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21.5 29C25.366 29 28.5 25.866 28.5 22C28.5 18.134 25.366 15 21.5 15C17.634 15 14.5 18.134 14.5 22C14.5 25.866 17.634 29 21.5 29ZM25.2979 20.4301C25.6396 20.0884 25.6396 19.5344 25.2979 19.1926C24.9562 18.8509 24.4022 18.8509 24.0605 19.1926L20.3013 22.9519L18.9421 21.5935C18.6003 21.2519 18.0463 21.2521 17.7047 21.5939C17.3631 21.9357 17.3632 22.4897 17.705 22.8313L19.6829 24.808C20.0246 25.1496 20.5785 25.1495 20.9202 24.8078L25.2979 20.4301Z" fill="#00AD76"/></svg>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="am-payment_item">
                            <div class="am-payment_item_info">
                                <h3>{{ $this->cancelledSessions }}</h3>
                                <span>{{ __('admin/general.rescheduled_sessions') }}</span>
                            </div>
                            <div class="am-payment_item_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="30" viewBox="0 0 29 30" fill="none"><path d="M0.5 12.1283C0.5 7.72848 0.5 5.52859 1.86684 4.16176C3.23367 2.79492 5.43356 2.79492 9.83333 2.79492H14.5C18.8998 2.79492 21.0997 2.79492 22.4665 4.16176C23.8333 5.52859 23.8333 7.72848 23.8333 12.1283V16.7949C22.0955 17.0245 17.9248 16.3879 16.3368 19.9503C15.5009 22.2027 19.8623 26.0568 17.1895 26.1119C16.3971 26.1283 15.5061 26.1283 14.5 26.1283H9.83333C5.43356 26.1283 3.23367 26.1283 1.86684 24.7614C0.5 23.3946 0.5 21.1947 0.5 16.7949V12.1283Z" fill="#7FD2C0"/><rect x="2.8833" y="8.77734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="10.4165" y="8.77734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="17.9497" y="8.77734" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="2.8833" y="16.6445" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><rect x="10.4165" y="16.6445" width="3.5" height="3.5" rx="1.16667" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.625C7.98325 0.625 8.375 1.01675 8.375 1.5V3.83333C8.375 4.31658 7.98325 4.70833 7.5 4.70833C7.01675 4.70833 6.625 4.31658 6.625 3.83333V1.5C6.625 1.01675 7.01675 0.625 7.5 0.625Z" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M16.8335 0.625C17.3167 0.625 17.7085 1.01675 17.7085 1.5V3.83333C17.7085 4.31658 17.3167 4.70833 16.8335 4.70833C16.3502 4.70833 15.9585 4.31658 15.9585 3.83333V1.5C15.9585 1.01675 16.3502 0.625 16.8335 0.625Z" fill="#00AD76"/><path fill-rule="evenodd" clip-rule="evenodd" d="M21.9009 29.8242C25.7669 29.8242 28.9009 26.6902 28.9009 22.8242C28.9009 18.9582 25.7669 15.8242 21.9009 15.8242C18.0349 15.8242 14.9009 18.9582 14.9009 22.8242C14.9009 26.6902 18.0349 29.8242 21.9009 29.8242ZM19.5932 18.2171C19.8885 17.9201 20.3687 17.9188 20.6657 18.2141L22.4407 19.9792C22.5839 20.1215 22.6644 20.315 22.6644 20.5169C22.6644 20.7188 22.5839 20.9123 22.4407 21.0546L20.6657 22.8197C20.3687 23.1151 19.8885 23.1137 19.5932 22.8167C19.2979 22.5197 19.2993 22.0396 19.5962 21.7443L20.0677 21.2755L17.3455 21.2758C16.9267 21.2758 16.5871 20.9363 16.5871 20.5175C16.587 20.0987 16.9265 19.7591 17.3453 19.7591L20.0681 19.7588L19.5962 19.2896C19.2993 18.9942 19.2979 18.5141 19.5932 18.2171ZM24.2203 22.8303C24.5156 23.1272 24.5143 23.6074 24.2173 23.9027L23.7454 24.3719L26.4682 24.3722C26.887 24.3723 27.2265 24.7119 27.2265 25.1307C27.2264 25.5495 26.8869 25.889 26.468 25.8889L23.7458 25.8886L24.2173 26.3574C24.5143 26.6527 24.5156 27.1329 24.2203 27.4299C23.925 27.7268 23.4449 27.7282 23.1479 27.4329L21.3728 25.6678C21.2296 25.5255 21.1492 25.3319 21.1492 25.1301C21.1492 24.9282 21.2296 24.7347 21.3728 24.5923L23.1479 22.8272C23.4449 22.5319 23.925 22.5333 24.2203 22.8303Z" fill="#00AD76"/></svg>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>    
        <div class="am-insights_section am-activity">
            <div class="am-insights_header">
                <div class="am-insights_title">
                    <h2>{{ __('admin/general.user_metrics_activity') }}</h2>
                    <p>{{ __('admin/general.track_manage_income') }}</p>
                </div>
            </div>
            <div class="am-insights_content">
                <div class="am-activity_card">
                    <div class="am-activity_user">
                        <div class="am-activity_user_info">
                            <span>{{ __('admin/general.total_users') }}</span>
                            <strong>{{ $this->usersCount }}</strong>
                        </div>
                        @if ($this->users->isNotEmpty())
                        <figure class="am-activity_user_img">
                            @foreach ($this->users as $user)
                                @if (!empty($user->profile?->image) && Storage::disk(getStorageDisk())->exists($user->profile?->image))
                                    <img src="{{ url(Storage::url($user->profile?->image)) }}" alt="{{ $user->profile?->image }}">
                                @else
                                    <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $user->profile?->image }}" />
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="am-activity_data">
                        <div class="am-activity_data_item">
                            <div class="am-activity_data_user">
                                <span>
                                {{ $tutor_name }}
                                    <strong>{{ $this->tutorsCount }}</strong>
                                </span>
                                <a href="{{ route('admin.users', ['role' => 'tutor']) }}" target="_blank" class="am-activity_data_user_link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none"><g opacity="0.6"><path d="M3.16675 13.8327L13.8334 3.16602M13.8334 3.16602V10.4993M13.8334 3.16602H6.50008" stroke="black" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                                </a>
                            </div>
                            @if ($this->tutors->isNotEmpty())   
                            <div class="am-activity_data_user_img">
                                <figure>
                                    @foreach ($this->tutors as $tutor)
                                        @if (!empty($tutor->profile?->image) && Storage::disk(getStorageDisk())->exists($tutor->profile?->image))
                                            <img src="{{ url(Storage::url($tutor->profile?->image)) }}" alt="{{ $tutor->profile?->image }}">
                                        @else
                                            <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $tutor->profile?->image }}" />
                                        @endif
                                    @endforeach
                                </figure>
                                </div>
                            @endif
                        </div>
                        <div class="am-activity_data_item">
                            <div class="am-activity_data_user">
                                <span>
                                {{ $student_name }}
                                    <strong>{{ $this->studentsCount }}</strong>
                                </span>
                                
                                <a href="{{ route('admin.users', ['role' => 'student']) }}" target="_blank" class="am-activity_data_user_link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none"><g opacity="0.6"><path d="M3.16675 13.8327L13.8334 3.16602M13.8334 3.16602V10.4993M13.8334 3.16602H6.50008" stroke="black" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                                </a>
                            </div>
                            @if ($this->students->isNotEmpty())
                            <div class="am-activity_data_user_img">
                                <figure>
                                    @foreach ($this->students as $student)
                                        @if (!empty($student->profile?->image) && Storage::disk(getStorageDisk())->exists($student->profile?->image))
                                            <img src="{{ url(Storage::url($student->profile?->image)) }}" alt="{{ $student->profile?->image }}">
                                        @else
                                            <img src="{{ resizedImage('placeholder.png',34,34) }}" alt="{{ $student->profile?->image }}" />
                                        @endif
                                    @endforeach
                                </figure>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="am-activity_card am-activity_comparison_card">
                    <div class="am-activity_card_heading">
                        <h3>{{ __('admin/general.monthly_user_comparison') }}</h3>
                    </div>
                    <div class="am-activity_user_comparison">
                        <span>
                            {{ __('admin/general.this_month') }}
                            <strong class="{{ $difference < 0? 'am-loss' : 'am-profit' }}">
                                {{ number_format($currentMonthUsers) }} {{ __('admin/general.users') }} 
                                <em>{{ $difference > 0 ? '+':''}}{{ $difference }}%</em>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6.86879 5.79869L4.06487 8.60261C3.20811 9.45937 2.77974 9.88774 2.75079 10.2555C2.72568 10.5746 2.85485 10.8865 3.09826 11.0944C3.37879 11.334 3.98461 11.334 5.19624 11.334H10.8041C12.0157 11.334 12.6215 11.334 12.9021 11.0944C13.1455 10.8865 13.2746 10.5746 13.2495 10.2555C13.2206 9.88774 12.7922 9.45937 11.9355 8.60261L9.13153 5.79869C8.73552 5.40267 8.53751 5.20466 8.30918 5.13047C8.10834 5.06522 7.89199 5.06522 7.69115 5.13047C7.46282 5.20466 7.26481 5.40267 6.86879 5.79869Z" fill="#17B26A"/>
                                </svg>
                            </strong>
                        </span>
                        <span>
                            {{ __('admin/general.last_month') }}
                            <strong>
                                {{ number_format($lastMonthUsers) }} {{ __('admin/general.users') }} 
                            </strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>     
    </div>
</div>
@push('styles')
    @vite([
        'public/admin/css/daterangepicker.css'
    ])
@endpush

@push('scripts')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>

<script>
    document.addEventListener('livewire:initialized', function() {

        jQuery('#revenue-date-range').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: @json(__('general.clear'))
            },
            autoUpdateInput: true,
            alwaysShowCalendars: false,
            ranges: {
                'This month': [moment().startOf('month'), moment().endOf('month')],
                'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This year': [moment().startOf('year'), moment().endOf('year')],
                'Last year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }
    
        ,function(start, end, label) {
            $('#revenue-date-range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
         });

         jQuery('#session-date-range').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: @json(__('general.clear'))
            },
            autoUpdateInput: true,
            alwaysShowCalendars: false,
            ranges: {
                'This month': [moment().startOf('month'), moment().endOf('month')],
                'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This year': [moment().startOf('year'), moment().endOf('year')],
                'Last year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }
    
        ,function(start, end, label) {
            $('#session-date-range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
         });

         $('#revenue-date-range').on('apply.daterangepicker', function(ev, picker) {
            @this.set('revenueStartDate', picker.startDate.format('YYYY-MM-DD'));
            @this.set('revenueEndDate', picker.endDate.format('YYYY-MM-DD'));
        });

         $('#session-date-range').on('apply.daterangepicker', function(ev, picker) {
            @this.set('sessionStartDate', picker.startDate.format('YYYY-MM-DD'));
            @this.set('sessionEndDate', picker.endDate.format('YYYY-MM-DD'));
        });

});
</script>
@endpush