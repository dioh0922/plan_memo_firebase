<template>
    <v-container>
        <v-row v-if="isInit">
            <v-col cols="4" rows="4">
                <RegisterDialog @registerDone="fetchList"/>
            </v-col>
            <v-col v-for="item in filterList" :key="item.id" cols="4" rows="4">
                <v-card class="my-2" style="white-space:pre-wrap; word-wrap:break-word;">
                    <v-card-title>
                        <div class="d-flex justify-end">
                            <p>{{item.summary}}</p>
                            <v-spacer></v-spacer>
                            <v-btn prepend-icon="mdi-delete" size="small" variant="text" @click="deletePlan(item.id)"></v-btn>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <DetailDialog 
                        :summary="item.summary"
                        :detail="item.detail"
                        :id="item.id"/>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted, computed } from 'vue'
import RegisterDialog from './registerDialog.vue'
import DetailDialog from './detailDialog.vue'

const isInit = ref(false)

const list = ref([])

const deletePlan = async (id) => {
  axios.delete(process.env.VUE_APP_API_URL + '/delete.php/' + id)
  .then((res) => {
    if(res.data.success){
      fetchList()
    }
  }).catch(err => {
    console.log(err)
  })
}

const filterList = computed(() => {
  return list.value.filter(item => item.is_delete == 0)
})

const fetchList = () => {
  axios.get(process.env.VUE_APP_API_URL + '/list.php')
  .then(res => {
    console.log(res)
    if(res.data.success){
      list.value = res.data.data
    }
  }).catch(err => {
    console.log(err)
  })
}

onMounted(() => {
  isInit.value = true
  fetchList()
})
</script>

