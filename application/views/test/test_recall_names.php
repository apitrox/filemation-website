<div id="prefetch">
  <input class="typeahead" type="text" placeholder="Countries">
</div>

<script type="text/javascript">
	var countries = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 10,
	prefetch: {
	  ttl: 0,
	  // url points to a json file that contains an array of country names, see
	  // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
	  url: '/json/GetFileCriteriaRecallNames/?file_definition_id=1000000014&file_criteria_id=1000000215',
	  // the json file contains an array of strings, but the Bloodhound
	  // suggestion engine expects JavaScript objects so this converts all of
	  // those strings
	  filter: function(list) {
	    return $.map(list, function(country) { return { name: country }; });
	  }
	}
   });

   // kicks off the loading/processing of `local` and `prefetch`
   countries.initialize();

   // passing in `null` for the `options` arguments will result in the default
   // options being used
   $('#prefetch .typeahead').typeahead(null, {
	name: 'countries',
	displayKey: 'name',
	// `ttAdapter` wraps the suggestion engine in an adapter that
	// is compatible with the typeahead jQuery plugin
	source: countries.ttAdapter()
   });
   
   countries.clearRemoteCache();
   countries.clearPrefrechCache();
   //engine.clear();
   //engine.clearPrefrechCache();
   //engine.initialize(true);
</script>