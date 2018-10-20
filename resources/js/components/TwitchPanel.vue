<template>
    <div class="twitch-panel">
        <div class="row mb-5">
            <div class="col">

                <div class="card">
                    <div class="card-body">
                        <div class="twitch-panel__avatars" v-if="streamers.length > 1">
                            <ul>
                                <li @click.stop.prevent="switchStreamer(streamer)" v-for="streamer in streamers" :class="{'is-active':(streamer.id == streamer_selected.id)}">
                                    <img :src="streamer.main_channel.profile_image_url">
                                </li>
                            </ul>
                        </div>
                        <div class="twitch-panel__inner" v-if="streamer_selected.id">
                            <div class="twitch-panel__head">
                                <a class="twitch-panel__head-link" target="_blank" :href="streamer_selected.main_url">
                                    <img v-if="streamers.length == 1" :src="streamer_selected.main_channel.profile_image_url" class="twitch-panel__head-image"/>
                                    <span class="twitch-panel__head-name">
                                        {{streamer_selected.main_channel.profile_name}} <template v-if="streamer_selected.is_online">is <span>streaming now</span></template>
                                    </span>
                                </a>
                            </div>
                            <div class="twitch-panel__iframe">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe
                                            :src="iframe_url"
                                            class="embed-responsive-item"
                                            height="400"
                                            width="300"
                                            frameborder="0"
                                            scrolling="no"
                                            allowfullscreen="true">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        streamers: {
            default: []
        }
    },
    data() {
        return {
            streamer_selected: {}
        };
    },
    mounted() {
        this.streamer_selected = this.streamers[0];
        console.log(this.streamer_selected);
    },
    computed: {
        iframe_url() {
            if (this.streamer_selected.streamer_main_channel == "twitch") {
                return `https://player.twitch.tv/?channel=${
                    this.streamer_selected.twitch_username
                }&muted=true&autoplay=true`;
            }
            return `https://www.youtube.com/embed/live_stream?channel=${
                this.streamer_selected.youtube_channel_id
            }&mute=1&autoplay=1&cc_load_policy=1`;
        }
    },
    methods: {
        switchStreamer(streamer) {
            this.streamer_selected = streamer;
        }
    }
};
</script>
