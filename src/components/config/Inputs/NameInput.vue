<template>
  <div class="container_p">
    <p>Alterar nome:</p>
    <div class="input_container">
      <input
        class="name_input"
        type="text"
        placeholder="Digite o novo nome"
        v-model="name"
        :style="{ borderColor: colorStore.color }"
      />
      <button
        class="name_btn"
        :style="{
          backgroundColor: colorStore.color,
        }"
        @click="updateUser.updateUser(userStore.id, 'nome', name)"
      >
        Alterar
      </button>
    </div>
  </div>
</template>

<script setup>
import { useUsersStore } from "@/stores/users"
import { useColorStore } from "@/stores/colors"
import { useUpdateUser } from "@/stores/updateUser"

const colorStore = useColorStore()
const userStore = useUsersStore()
const updateUser = useUpdateUser()

const name = userStore.name
</script>

<style scoped>
.input_container {
  display: flex;
  align-items: center;
  gap: 14px;
}

.container_p {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 3px;
}

p {
  font-size: 15px;
  font-style: italic;
  margin-left: 4px;
}

.name_input {
  border-radius: 2px;
  border: 1px solid;
  transition: 0.3s;
  padding: 4px 12px;
}

.name_btn {
  border: none;
  padding: 6px 14px;
  border-radius: 6px;
  color: white;
  font-weight: 600;
  opacity: 0.9;
  width: 100%;
  transition: 0.3s;
  cursor: pointer;
}

.name_btn:hover {
  opacity: 1;
  transform: scale(1.05);
}
</style>
