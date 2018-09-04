---
layout: default
title: New Stuff
---

{% for new in site.newstuff %}
<div class="new">
  <a href="{{ new.link }}"><img src="{{ new.image_path }}" alt="{{ new.title }}" width="500px"/></a>
  <a href="{{ new.link }}">{{ new.content }}</a>
</div>

<hr>
<hr>

{% endfor %}
