@for ($i = 0; $i < $perPage; $i++)
    <tr class="am-skeleton-row">
        <td data-label="Dispute">
            <div class="am-dispute-skeleton">
                <div class="am-skeleton-loader am-title"></div>
                <div class="am-skeleton-loader am-id"></div>
            </div>
        </td>
        <td data-label="Session">
            <div class="am-list-wrap">
                <figure class="am-img-rounded am-skeleton-img"></figure>
                <div class="am-session-skeleton">
                    <div class="am-skeleton-loader am-subject"></div>
                    <div class="am-skeleton-loader am-time"></div>
                </div>
            </div>
        </td>
        <td data-label="User">
            <div class="am-list-wrap">
                <figure class="am-skeleton-img"></figure>
                <div class="am-user-skeleton">
                    <div class="am-skeleton-loader am-name"></div>
                    <div class="am-skeleton-loader am-email"></div>
                </div>
            </div>
        </td>
        <td data-label="Date Created">
            <div class="am-skeleton-loader am-date"></div>
        </td>
        <td data-label="Status">
            <div class="am-status-tag">
                <div class="am-skeleton-loader am-status"></div>
                <div class="am-skeleton-loader am-view-btn"></div>
            </div>
        </td>
    </tr>
@endfor