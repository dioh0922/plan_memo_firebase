<template>
  <v-card @click="active = true" class="my-2" style="white-space:pre-wrap; word-wrap:break-word;">
    <v-card-title>
      新規追加
    </v-card-title>
    <v-card-actions>
      <v-dialog v-model="active" activator="parent">
        <v-card>
          <v-card-text>
            <v-text-field v-model="summary" label="タイトル"></v-text-field>
            <v-textarea v-model="detail" label="内容"></v-textarea>
          </v-card-text>

          <v-card-actions>
            <v-btn color="success" @click="addIdea">add</v-btn>
            <v-btn @click="active = false">close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-actions>
  </v-card>
</template>
<script setup>
  import axios from 'axios'
  import { ref } from 'vue'
  const active = ref(false)
  const summary = ref("")
  const detail = ref("")
  const addIdea = async () => {
    axios.post(process.env.VUE_APP_API_URL + '/create.php', {summary: summary.value, detail: detail.value})
    .then((res) => {
      if(res.data.success){
        //fetchList()
      }
    }).catch(err => {
      console.log(err)
    })
  }
</script>