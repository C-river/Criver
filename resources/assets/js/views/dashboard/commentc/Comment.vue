<template>
  <div class="row">
    <vue-table :title="$t('page.comments')" :fields="fields" api-url="commentc" show-paginate @table-action="tableActions"></vue-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
	  fields: [
	    {
		  name: 'id',
		  trans: 'table.id',
		  titleClass: 'width-5-percent text-center'
		},
		{
		  name: 'username',
		  trans: 'table.username'
		  
		},
		{
		  name: 'type',
		  trans: 'table.comment_type'
		},
		{
		  name: 'commentable',
		  trans: 'table.comment_title'
		},
		{
		  name: 'created_at',
		  trans: 'table.created_at'
		},
		{
		  name: '__actions',
		  trans: 'table.action'
		}
	  ]
	}
  },
  methods: {
    username(value) {
	  return value.data.value
	},
	tableActions(action, data) {
	  if (action == 'edit-item') {
	    this.$router.push('/dashboard/commentsc/' + data.id + '/edit')
	  } else if (action == 'delete-item') {
	    this.$http.delete('commentsc/' + data.id)
		  .then((response) => {
		    toastr.success('You delete the comment success!')
			
			this.$emit('reload')
		  }).catch((response) => {
		    toastr.error(response.status + response.statusText)
		  })
		  
	  }
	}
  }
}
</script>