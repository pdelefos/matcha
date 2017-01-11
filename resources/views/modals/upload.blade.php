<div class="profile-modal">
    <div class="profile-modal__content profilpic-modal">
        <a href="{{ route('root') }}/home/profil/me" class="modal-close"><div data-icon="ei-close-o" data-size="m"></div></a>
        <h2 class="profile-modal__title">photo de profil</h2>
        <form action="{{ route('profilpic') }}" method="post" enctype="multipart/form-data">
        <div class="hublot" style=""></div>
        <input id="my-pic" type="file" name="picture" onchange="previewFile()" class="inputfile">
        <label for="my-pic" class="btn-submit pic-upload">choisir un fichier</label>
        <!--<a href="{{ route('profilpic') }}" class="btn-submit submit-picture">envoyer</a>-->
        <input class="form__input btn-submit submit-picture" type="submit" name="submit" value="envoyer">
        </form>
    </div>
</div>
<script type="text/javascript">
    function previewFile() {
        const preview = document.querySelector('.hublot')
        const file = document.querySelector('input[type=file]').files[0]
        const reader = new FileReader()

        reader.onloadend = function () {
            console.log(reader)
            preview.style = "background-image:url(" + reader.result + ")"
        }

        if (file)
            reader.readAsDataURL(file)
        else
            preview.style = ""
    }
</script>