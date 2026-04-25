<div class="am-quizlist_wrap am-quizlist-skeleton">
    <ul>  
        @for($i = 0; $i < $total; $i++)
            <li>
                <div class="am-quizlist_item">
                    <span></span>
                    <div class="am-quizlist_item_content">
                        <div class="am-quizlist_coursename">
                            <span></span>
                            <div class="am-itemdropdown"></div>
                        </div>
                        <h3></h3>
                      <ul class="am-quizlist_item_footer">
                        <li>
                            <span></span>
                            <em></em>
                        </li>
                        <li>
                            <span></span>
                            <em></em>
                        </li>
                        <li>
                            <span></span>
                            <em></em>
                        </li>
                        <li>
                            <span></span>
                            <em></em>
                        </li>
                      </ul>
                    </div>
                </div>
            </li>
        @endfor
    </ul>
</div>