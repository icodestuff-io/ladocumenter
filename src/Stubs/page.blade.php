# {{$group->name}}

{{$group->description}}

---
@foreach($routes as $route)
@if(!is_null($route->endpoint))

- [{{$route->endpoint->name}}](#{{\Illuminate\Support\Str::slug($route->endpoint->name)}})

@endif
@endforeach

@foreach($routes as $route)

@if(!is_null($route->endpoint))
<a name="{{\Illuminate\Support\Str::slug($route->endpoint->name)}}"></a>
## {{$route->endpoint->name}}

{{$route->endpoint->description}}
@endif
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`{{$route->httpMethod}}`|`{{$route->uri}}`|`{{($route->requiresAuth) ? 'true': 'false'}}`|

@if(!is_null($route->queryParams))
### Query Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
@if(is_array($route->queryParams))
@foreach($route->queryParams as $param)
|`{{$param->name}}`|`{{$param->type}}`|`{{$param->status}}`|`{{$param->description}}`|
@endforeach
@else

@endif

@endif

@if(!is_null($route->bodyParams))
### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
@foreach($route->bodyParams as $param)
|`{{$param->name}}`|`{{$param->type}}`|`{{$param->status}}`|`{{$param->description}}`|
@endforeach

@endif

@foreach($route->responses as $response)

@if($response->status >= 400)
> {danger} Example Error Response

@else
> {success} Example Success Response
@endif
Code `{{$response->status}}`

Content

```json
{{$response->file}}
```
@endforeach


@endforeach
