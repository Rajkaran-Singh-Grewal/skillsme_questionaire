<template>
    <div>
        <ul>
            <li>
                <router-link to="/dashboard">Dashboard</router-link>
            </li>
            <li>
                <router-link to="/questionnaire">Questionnaire</router-link>
            </li>
            <li>
                <router-link to="/response">Response</router-link>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    components:{
        DashboardComponent,
        QuestionnaireComponent,
        ResponseComponent
    }
}
</script>