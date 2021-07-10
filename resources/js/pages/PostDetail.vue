<template>
  <div>
    <div v-if="!loaded">
      <Loader/>
    </div>
    <div 
    v-else
    class="card mb-3">

      <div class="card-body">

        <div class="d-flex justify-content-between">
          <h5 class="card-title">{{ post.title }}</h5>
          <span v-if="post.category" class="badge badge-success custom-badge">{{ post.category.name }}</span>
        </div>

        <i>{{ FormatDate.format(post.created_at) }}</i>
        <p class="card-text">{{ post.content }}</p>
        <div>
          <i
          v-for="tag in post.tags"
          :key="'t'+tag.id"
          >{{ tag.name }}</i>
        </div>

      </div>

    </div>

  </div>
</template>

<script>
import axios from 'axios';
import FormatDate from '../classes/FormatDate';
import Loader from '../components/Loader.vue';

export default {
  name: 'PostDetail',
  components:{
    Loader
  },
  data(){
    return{
      post:{},
      loaded: false,
      FormatDate
    }
  },
  mounted(){
    //console.log(this.$route.params.slug);
    this.loaded =false;

    axios.get('http://127.0.0.1:8000/api/posts/'+this.$route.params.slug)
      .then(res=>{
        console.log(res.data);
        if(res.data.success){
          this.post = res.data.data;
          this.loaded = true;
        }else{
          //reindirizzo verso la pagina error404
          this.$router.push({name: 'error404', params:{slug}});
        }
      })
      .catch(err=>{
        console.log(err);
      })
  }
}
</script>

<style lang="scss" scoped>
.custom-badge{
  display: inline-block;
  height: 2rem;
  line-height: 2rem;
}
i{
  display: inline-block;
  margin-right: 10px;
}
</style>