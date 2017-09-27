#!groovy​
node {
    try {
        slackSend channel: '#joomlashacktemplates', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Triggering update on a set of templates..."

        stage('Civic') {
            build 'JoomlaShack-Templates/Civic-Wright'
        }

        stage('Travertine') {
            build 'JoomlaShack-Templates/Travertine-Wright'
        }
        
        stage('Clementine') {
            build 'JoomlaShack-Templates/Clementine-Wright'
        }
        
        stage('Community') {
            build 'JoomlaShack-Templates/Community-Wright'
        }
        
        stage('Alasse') {
            build 'JoomlaShack-Templates/Alasse-Wright'
        }
        
        stage('Flow') {
            build 'JoomlaShack-Templates/Flow-Wright'
        }
        
        stage('Wylia2') {
            build 'JoomlaShack-Templates/Wylia2-Wright'
        }
        
        stage('Unlimited') {
            build 'JoomlaShack-Templates/Unlimited-Wright'
        }
        
        stage('Tripod') {
            build 'JoomlaShack-Templates/Tripod-Wright'
        }
        
        stage('Novitas') {
            build 'JoomlaShack-Templates/Novitas-Wright'
        }
       
        stage('ABC') {
            build 'JoomlaShack-Templates/ABC-Wright'
        }
        
        stage('Elan') {
            build 'JoomlaShack-Templates/Elan-Wright'
        }
        
        stage('Mondrian') {
            build 'JoomlaShack-Templates/Mondrian-Wright'
        }
        
        stage('Optimus') {
            build 'JoomlaShack-Templates/Optimus-Wright'
        }
        
        stage('Breezy') {
            build 'JoomlaShack-Templates/Breezy-Wright'
        }
        
        stage('Impacto') {
            build 'JoomlaShack-Templates/Impacto-Wright'
        }
        
        stage('Keelny') {
            build 'JoomlaShack-Templates/Keenly-Wright'
        }
        
        stage('Onyx') {
            build 'JoomlaShack-Templates/Onyx-Wright'
        }
        
        stage('Techie') {
            build 'JoomlaShack-Templates/Techie-Wright'
        }
        
        stage('Vintage') {
            build 'JoomlaShack-Templates/Vintage-Wright'
        }

        slackSend channel: '#joomlashacktemplates', color: 'good', message: "${env.JOB_NAME} #${env.BUILD_NUMBER}. Finished"
    } catch (e) {
        slackSend channel: '#joomlashacktemplates', color: 'danger', message: "${env.JOB_NAME} #${env.BUILD_NUMBER} FAILED"
        // Force a failure
        sh "exit 1" 
    }
}
