<!-- Search bar -->
<div class="search-wrapper1" style="margin-top: 55px">
    <div class="container2" style="padding-top:20px">
        <form action="index.php?act=dsphim" id='search-form' method='POST' class="search">
            <input type="text" class="search__field" name="kys" placeholder="Tìm kiếm phim">
           
            <input type='submit' name="seach" class="btn btn-md btn--danger search__button"value="Tìm Kiếm ">
        </form>
    </div>
</div>
<style>
   .search-wrapper1 {
    width: 100%;
    background: rgba(0, 0, 0, 0.8);
 
    margin-top: 55px;
}

.container2 {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    justify-content: center;
}

.search {
    display: flex;
    align-items: center;
    gap: 20px;
    width: 80%;
    position: relative;
}

.search__field {
    flex: 1;
    height: 40px;
    padding: 0 15px;
    margin: 0;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.search__button {
    height: 40px;
    margin-top:35px ;
    margin-left: 70px;
    white-space: nowrap;
    padding: 0 20px;
    border-radius: 4px;
    cursor: pointer;
    background-color: red;
}
</style>