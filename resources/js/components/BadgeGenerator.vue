<template>
    <div class="container">
        <div class="justify-content-center">
            <iframe class="badge-generator__preview" :src="previewLink" ref="previewFrame"></iframe>

            <div class="form-group">
                <label class="font-weight-bold" for="tagline">Tagline</label>
                <div class="input-group">
                    <input v-model="parameters.tagline" id="tagline" class="form-control" type="text" />
                    <div class="input-group-append">
                        <button @click="preview('tagline')" class="btn btn-secondary" type="button">Preview</button>
                    </div>
                </div>
                <small class="form-text text-muted">The text after the shipstreams.com domain</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold" for="twitter">Twitter</label>
                <div class="input-group">
                    <input v-model="parameters.twitter" id="twitter" class="form-control" type="text" />
                    <div class="input-group-append">
                        <button @click="preview('twitter')" class="btn btn-secondary" type="button">Preview</button>
                    </div>
                </div>
                <small class="form-text text-muted">Your Twitter username (e.g. @shipstreams)</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold" for="youtube">YouTube</label>
                <div class="input-group">
                    <input v-model="parameters.youtube" id="youtube" class="form-control" type="text" />
                    <div class="input-group-append">
                        <button @click="preview('youtube')" class="btn btn-secondary" type="button">Preview</button>
                    </div>
                </div>
                <small class="form-text text-muted">Your YouTube username</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold" for="website">Website</label>
                <div class="input-group">
                    <input v-model="parameters.website" id="website" class="form-control" type="text" />
                    <div class="input-group-append">
                        <button @click="preview('website')" class="btn btn-secondary" type="button">Preview</button>
                    </div>
                </div>
                <small class="form-text text-muted">Your website (e.g. shipstreams.com)</small>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold" for="customMessage">Custom message</label>
                <div class="input-group">
                    <input v-model="parameters.customMessage" id="customMessage" class="form-control" type="text" />
                    <div class="input-group-append">
                        <button @click="preview('customMessage')" class="btn btn-secondary" type="button">Preview</button>
                    </div>
                </div>
                <small class="form-text text-muted">A completely custom message (e.g. "Shipping live is awesome!")</small>
            </div>

            <div class="alert alert-success mb-3" v-if="generatedLink" ref="successAlert">
                <strong>Looking good! Your badge link is:</strong><br>
                <a target="_blank" :href="badgeLink">{{ badgeLink }}</a><br><br>

                You can now add a BrowserSource in OBS and paste in the link.
                Don't forget to set the height to 195px and the width to 950px.
                You can also watch the preview of your whole badge below.
            </div>

            <button @click="generateLink" class="btn btn-primary">Generate my badge link</button>
        </div>
    </div>
</template>

<script>
    import qs from 'query-string'

    export default {
        methods: {
            preview(field) {
                const query = this.buildQuery()
                this.previewLink = `${query}&preview=${field}`
                this.$refs.previewFrame.scrollIntoView({ block: "start", behavior: "smooth" })
            },

            generateLink() {
                this.badgeLink = `https://shipstreams.com${this.buildQuery()}`
                this.generatedLink = true
            },

            buildQuery() {
                const parameters = Object.keys(this.parameters).reduce((p, c) => {
                    if (this.parameters[c].length) p[c] = this.parameters[c];
                    return p;
                }, {});

                return `/badge?${qs.stringify(parameters)}`
            }
        },

        data() {
            return {
                generatedLink: false,
                badgeLink: "/badge",
                previewLink: "/badge",
                parameters: {
                    tagline: "",
                    twitter: "",
                    youtube: "",
                    website: "",
                    customMessage: ""
                }
            }
        },
    }
</script>
