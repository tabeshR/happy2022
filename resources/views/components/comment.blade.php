<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ $route }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارسال دیدگاه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="position: absolute;left: 5px;top: 18px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="commentable_id" value="{{ $subject_id}}">
                    <input type="hidden" name="commentable_type" value="{{ get_class($subject_type) }}">
                    <input type="hidden" id="parent_id" name="parent_id" value="">
                    <input type="hidden">
                    <label for="">دیدگاه خود را بنویسید : </label>
                    <textarea class="form-control" name="comment" id="" cols="30" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"> ارسال دیدگاه</button>
                </div>
            </div>
        </form>
    </div>
</div>
