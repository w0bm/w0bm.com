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

<script id="paginationtmpl" type="text/x-handlebars-template">
    <nav class="pull-right">
        <ul class="pagination">
            <li {{#unless prev_page_url}}class="disabled"{{/unless}}>
            <a href="{{prev_page_url}}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
            </li>
            {{#each pages}}
            <li {{#if active}}class="active"{{/if}}><a href="/api/messages/?page={{page}}">{{page}}</a></li>
            {{/each}}
            <li {{#unless next_page_url}}class="disabled"{{/unless}}>
            <a href="{{next_page_url}}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>
    </nav>
    <div class="clearfix"></div>
</script>

<script id="msgtmpl" type="text/x-handlebars-template">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{subject}}</h3>
        </div>
        <div class="panel-body">
            {{{content}}}
        </div>
        <div class="panel-footer">{{created_at}}</div>
    </div>
</script>
