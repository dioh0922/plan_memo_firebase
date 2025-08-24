<template>
    <v-btn @click="openDialog">開く
        <v-dialog v-model="active">
            <v-card>
                <v-card-text style="white-space:pre-wrap; word-wrap:break-word;">
                    <v-text-field :readonly="!editFlg" v-model="summary" ></v-text-field>
                    <v-textarea :readonly="!editFlg" v-model="detail" ></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-btn v-show="!editFlg" @click="editFlg = true" color="success">edit</v-btn>
                    <v-btn v-show="editFlg" @click="editPlan" color="warning">save</v-btn>
                    <v-btn @click="active = false">close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-btn>
</template>

<script setup>
  import axios from 'axios'
  import {ref, defineProps} from 'vue'
  const props = defineProps({
    summary: String,
    detail: String,
    id: Number
  })

  const openDialog = () => {
    active.value = true
    summary.value = props.summary
    detail.value = props.detail
  }

  const summary = ref("")
  const detail = ref("")

  const active = ref(false)
  const editFlg = ref(false)
  const editPlan = async () => {
    axios.put(process.env.VUE_APP_API_URL + '/edit.php/' + props.id, {summary: summary.value, detail: detail.value})
    .then((res) => {
      if(res.data.success){
        //fetchList()
      }
    }).catch(err => {
      console.log(err)
    })
  }

</script>