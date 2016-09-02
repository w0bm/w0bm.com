<script id="paginationtmpl" type="text/x-handlebars-template">
    <nav class="mitte">
        <ul class="pagination">
            {{#paginate pagination type="first"}}
            <li {{#if disabled}}class="disabled"{{/if}}><a href="#" data-page="{{n}}">First</a></li>
            {{/paginate}}
            {{#paginate pagination type="previous"}}
            <li {{#if disabled}}class="disabled"{{/if}}><a href="#" data-page="{{n}}">&laquo;</a></li>
            {{/paginate}}
            {{#paginate pagination type="middle" limit="7"}}
            <li {{#if active}}class="active"{{/if}}><a href="#" data-page="{{n}}">{{n}}</a></li>
            {{/paginate}}
            {{#paginate pagination type="next"}}
            <li {{#if disabled}}class="disabled"{{/if}}><a href="#" data-page="{{n}}">&raquo;</a></li>
            {{/paginate}}
            {{#paginate pagination type="last"}}
            <li {{#if disabled}}class="disabled"{{/if}}><a href="#" data-page="{{n}}">Last</a></li>
            {{/paginate}}
        </ul>
    </nav>
    <div class="clearfix"></div>
</script>