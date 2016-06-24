<script id="comlist" type="text/x-handlebars-template">
            {{#each data as |value key|}}
            <div class="panel panel-default">
                <div class="panel-body" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" data-index="{{key}}" data-id="{{id}}">{{{rendered_view}}}</div>
                <div class="panel-footer">"Video: <a href="/{{video_id}}">/{{video_id}}</a> | <time class="timeago" datetime="{{created_at}}" title="{{created_at}}">{{created_at}}</time></div>
            </div>
            {{else}}
            <div class="list-group-item">No comments</div>
            {{/each}}
        {{#if total}}
        <div class="panel-footer" id="pagination">
        </div>
        {{/if}}
</script>