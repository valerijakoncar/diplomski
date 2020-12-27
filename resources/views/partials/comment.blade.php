<div class="commentReplyHolder">
    <div class="comment">
        <div class="userFaHolder">
            <span class="fa fa-user
            @if($c->gender_id == 1)
            {{ "femaleUser " }}
            @else
            {{"maleUser "}}
            @endif
                "></span>
            <p class="memberSince">Member since</p>
            <?php
            $toDate = date_create($c->registered_at);
            $formattedDate = date_format($toDate, 'd.m.Y');
            ?>
            <p class="memberDate">{{$formattedDate}}</p>
        </div>
        <div class="commentRight">
            <div class="topPartComment">
                <span class="usernameComment">{{$c->username}}</span>
                <?php
                $toDate = date_create($c->posted_at);
                $formattedDate = date_format($toDate, 'd.m.Y H:i');
                ?>
                <span class="commPosted">{{$formattedDate}}</span>
                @if($c->updated_at)
                    <span class="editedComm">Edited</span>
                @endif
            </div>
            <div class="commentTextDiv">
                <div class="commText">{{$c->text}}</div>
            </div>
            <div class="bottomPartComment">
                <span class="fa fa-angle-down showReplies angle" data-id="{{$c->id}}"></span>
                <span class="fa fa-angle-up hideReplies angle" data-id="{{$c->id}}"></span>
                @if(session()->has('user'))
                    <span class="repply" data-id="{{$c->id}}">Repply</span>
                    @if(session('user')->id === $c->user_id)
                        {{--        session('user')->role_id == 2 && ibrisano iz uslova iznad    && njegoc komentar dodati--}}
                        <span class="fa fa-edit" data-id="{{$c->id}}"></span>
                        <span class="fa fa-trash" data-id="{{$c->id}}"></span>
                        {{--                    <input type="hidden" name="_token" id="csrf-token-comment" value="{{ Session::token() }}" />--}}
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="repliesDiv">

{{--        <div class="reply">--}}

{{--        </div>--}}
    </div>
</div>

