<template>
    <div>
        <div v-bind="getRootProps()">
            <input v-bind="getInputProps()" />
            <p v-if="isDragActive">Drop the files here ...</p>
            <p v-else>
                Drag 'n' drop some files here, or click to select files
            </p>
        </div>
    </div>
</template>

<script>
import { useDropzone } from "vue3-dropzone";

export default {
    name: "UseDropzoneDemo",
    setup() {
        const url = "/api/add-image";

        const saveFiles = (files) => {
            const formData = new FormData(); // pass data as a form
            for (var x = 0; x < files.length; x++) {
                // append files as array to the form, feel free to change the array name
                formData.append("images[]", files[x]);
            }

            // post the formData to your backend where storage is processed. In the backend, you will need to loop through the array and save each file through the loop.

            axios
                .post(url, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.info(response.data);
                })
                .catch((err) => {
                    console.error(err);
                });
        };

        function onDrop(acceptFiles, rejectReasons) {
            saveFiles(acceptFiles);
            console.log(rejectReasons);
        }

        const { getRootProps, getInputProps, ...rest } = useDropzone({
            onDrop,
        });

        return {
            getRootProps,
            getInputProps,
            ...rest,
        };
    },
};
</script>
