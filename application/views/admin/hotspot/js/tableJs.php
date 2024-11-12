<script type="text/javascript">
let table=$('.dt').DataTable( {
	"ajaxSource": "<?=site_url($url)?>/datatable",
	"columnDefs": [ {
	    "targets":  [0,10],
	    "orderable": false,
	} ],
	"order": [[ 1, "desc" ]],
} );


</script>