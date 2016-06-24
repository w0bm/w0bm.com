<script id="msglist" type="text/x-handlebars-template">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Messages</h3>
        </div>

        <div class="list-group" id="listitems">
            {{#each data as |value key|}}
            <a href="#" data-index="{{key}}" data-id="{{id}}" class="list-group-item {{#unless read}}list-group-item-info{{/unless}}">{{subject}}</a>
            {{else}}
            <div class="list-group-item">No messages</div>
            {{/each}}
        </div>
        {{#if total}}
        <div class="panel-footer" id="pagination">
        </div>
        {{/if}}
    </div>
</script>

<script id="msgtmpl" type="text/x-handlebars-template">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{subject}}</h3>
        </div>
        <div class="panel-body">
            {{{content}}}
        </div>
        <div class="panel-footer"><time class="timeago" datetime="{{created_at}}" title="{{created_at}}">{{created_at}}</time></div>
    </div>
</script>
