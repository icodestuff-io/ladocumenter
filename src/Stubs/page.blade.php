# {{$group->name}}

{{$group->description}}

---
@foreach($endpoints as $endpoint)
@if(!is_null($endpoint->meta))

- [{{$endpoint->meta->name}}](#{{$endpoint->meta->href}})

@endif
@endforeach

@foreach($endpoints as $endpoint)

@if(!is_null($endpoint->meta))
<a name="{{$endpoint->meta->href}}"></a>
## {{$endpoint->meta->name}}

{{$endpoint->meta->description}}
@endif
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`{{$endpoint->httpMethod}}`|`{{$endpoint->uri}}`|`{{($endpoint->requiresAuth) ? 'true': 'false'}}`|

@if(!is_null($endpoint->queryParams))
### Query Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
@if(is_array($endpoint->queryParams))
@foreach($endpoint->queryParams as $param)
|`{{$param->name}}`|`{{$param->type}}`|`{{$param->status}}`|`{{$param->description}}`|
@endforeach
@else

@endif

@endif

@if(!is_null($endpoint->bodyParams))
### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
@if(is_array($endpoint->bodyParams))
@foreach($endpoint->bodyParams as $param)
|`{{$param->name}}`|`{{$param->type}}`|`{{$param->status}}`|`{{$param->description}}`|
@endforeach
@else

@endif

@endif

@if(!is_null($endpoint->response))
@if(is_array($endpoint->response))
@foreach($endpoint->response as $response)

@if($response->status >= 400)
> {danger} Example Error Response

@else
> {success} Example Success Response
@endif
Code `{{$response->status}}`

Content

```json
{{$response->example}}
```
@endforeach
@else
@if($endpoint->response->status >= 400)
> {danger} Example Error Response

@else
> {success} Example Success Response
@endif
Code `{{$endpoint->response->status}}`

Content

```json
{!! $endpoint->response->example !!}
```
@endif
@endif


@endforeach
