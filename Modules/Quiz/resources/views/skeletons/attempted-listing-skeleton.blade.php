<div class="am-attemptedlist-skeleton">
    <table class="am-table ">
        <thead>
            <tr>
        
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
                <th><span></span></th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < $total; $i++)
                <tr>
                    <td data-label="Student">
                        <div class="am-quizlist_info am-quizlist_info_student">
                            <div class="am-quizlist_info_img">
                                <span></span>
                            </div>
                            <div class="am-quizlist_info_details">
                                <strong></strong>
                                <span></span>
                            </div>
                        </div>
                    </td>
                    <td data-label="Date & Time">
                        <span></span>
                        <em></em>
                    </td>
                    <td data-label="Question"><span></span></td>
                    <td data-label="Total Marks"><span></span></td>
                    <td data-label="Correct Answer"><span></span></td>
                    <td data-label="Incorrect Answer"><span></span></td>
                    <td data-label="Earned Marks"><span></span></td>
                    <td data-label="Result"><span></span></td>
                    <td data-label="Actions"><span></span></td>
                </tr>    
            @endfor
        </tbody>
    </table>
</div>