@foreach($comments as $comment)
<div class="card">
    <div class="card-header">
        <span class="float-right">  {{ $comment->user->name }}</span>
        <span class="float-left">
                                                   <span
                                                       class="ml-3 text-muted"> {{ jdate($comment->created_at)->ago() }}</span>
                              <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#exampleModal"
                                 onclick="event.preventDefault();changeParentId('{{ $parent_id }}')">پاسخ</a>
                              </span>
    </div>
    <div class="card-body">
        {{ $comment->comment }}

    </div>
</div>
@endforeach
