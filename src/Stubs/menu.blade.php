- ## Getting Started
  @foreach(config('ladocumenter.pages') as $page)
  - [{{$page}}](/&#123;&#123;route&#125;&#125;/&#123;&#123;version&#125;&#125;/{{strtolower($page)}})
  @endforeach

- ## Endpoints
  @foreach($namespaces as $namespaceKey => $namespaceValue)
  - [{{$namespaceKey}}](#)
    @foreach($namespaceValue as $classKey => $classValue)
    - [{{$classValue->group->name}}](/&#123;&#123;route&#125;&#125;/&#123;&#123;version&#125;&#125;/{{strtolower($namespaceKey)}}/{{str_replace(' ', '-', strtolower($classValue->group->name))}})
    @endforeach

  @endforeach
