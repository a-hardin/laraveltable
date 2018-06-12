# Laraveltable

The is a package for Laravel to build tables using your models

### Prerequisites

Laravel >=5.4 

## Deployment

Add package to your vendor folder.

In your app.php file under providers add:

```
Hardland\LaravelTable\LaravelTableServiceProvider::class
```

## How to use

In your controller add the following

```
use Hardland\Services\LaravelTable;
```

your function should look like the following:


```
public function PostTest(LaravelTable $table, Request $request)
{	
		
	// Add the columns you want to be displayed. Related tables can be used in the following format <model relation>.<column>
	// Currently only 1 to 1, 1 to many, and many to 1 relationships will work.
	$columns = ['Title', 'Status', 'Created', 'user.Username'];
	
	// initialize the table
	$postTable = $table->getLinkTable("App\Post", $columns, $request);
	
	// make the table have filters
	$postTable->setTableFilters(true);
	
	// Make columns links.
	$links = [
            'Title' => '/post/',
            'user.Username' => '/user/'
        ];
	$postTable->setLinkColumnArray($links);
	
	// Add any constraints to the query
	$constraints = [
            'user_id' => 1
        ];
	$postTable->setConstrantArray($constraints);
	
	// add any hidden inputs in your table
	$hiddenInputs = [
            "parentSelector" => "table",
            "url" => "/test/postTest"
        ];
	$postTable->setHiddenInputs($hiddenInputs);
	
	// send table in parts or json
	return view('test.postTest', array(
            'json' => $postTable->buildJson(),
            'hiddenInputs' => $postTable->getHiddenInputView(),
            'thead' => $postTable->getTheadView(),
            'tbody' => $postTable->getTbodyView(),
            'paginate' => $postTable->getPaginateView(),
        ));
		
}
```

An example of displaying table in view

```
    <div id="test">
        <h2> Blog Posts </h2>
        {!! $hiddenInputs !!}
        <table class="table table-striped">
            <thead>{!! $thead !!}</thead>
            <tbody>{!! $tbody !!}</tbody>
        </table>
        <div class="row">{!! $paginate !!}<div>
    <div>
```