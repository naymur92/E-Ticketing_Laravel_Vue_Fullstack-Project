<script setup>
import SearchTrain from "../Components/SearchTrain.vue";
</script>
<template>
  <div class="container">
    <div class="row my-5 d-flex align-items-center">
      <div class="col-md-6 col-sm-12 py-5">
        <!-- Search Train -->
        <SearchTrain />
        <!-- <form>
          <div class="row my-2">
            <div class="col-6">
              <div class="form-group">
                <label for="_from"><strong>From</strong></label>
                <v-select
                  id="_from"
                  v-model="from"
                  :options="stations"
                ></v-select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="_to"><strong>To</strong></label>
                <v-select id="_to" v-model="to" :options="stations"></v-select>
              </div>
            </div>
          </div>
          <div class="row my-2">
            <div class="col-6">
              <div class="form-group">
                <label for="_doj"><strong>Date of Journey</strong></label>
                <VueCtkDateTimePicker
                  only-date
                  no-button-now
                  format="YYYY-MM-DD"
                  formatted="YYYY-MM-DD"
                  input-size="lg"
                  label="Select Date"
                  auto-close="true"
                  id="_doj"
                  v-model="doj"
                />
              </div>
            </div>
          </div>
          <input
            type="submit"
            value="Search Train"
            class="btn btn-success form-control"
          />
        </form> -->
      </div>
      <div class="col-md-6 col-sm-12 position-relative">
        <img
          src="/assets/images/train-illustration-for-train-1.jpg"
          class="rounded"
          style="width: 100%"
          alt="train_illustration_image"
        />
        <span
          class="position-absolute"
          style="top: 10px; right: 15px; text-align: right; font-weight: 600"
          >Easy <span class="text-success">purchase</span> of
          <span class="text-success">tickets</span> using <br />
          online payment method</span
        >
        <div
          class="money-partners my-3 d-flex align-items-baseline position-absolute"
          style="top: 50px; right: 15px"
        >
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/bkash.png"
              alt="BKash a payment method of Bangladesh Railway"
            />
          </div>
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/nagad-32.png"
              alt="Nagad a payment method of Bangladesh Railway"
            />
          </div>
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/rocket.svg"
              alt="Rocket a payment method of Bangladesh Railway"
            />
          </div>
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/master-card.png"
              alt="MasterCard a payment method of Bangladesh Railway"
            />
          </div>
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/visa.png"
              alt="Visa a payment method of Bangladesh Railway"
            />
          </div>
          <div class="money-logo">
            <img
              src="https://eticket.railway.gov.bd/v2/assets/img/home/nexus-debit.svg"
              alt="DBBL Nexus a payment method of Bangladesh Railway"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <p>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorem, culpa
        tempora nihil, consectetur, aut inventore iusto velit voluptas ipsum ab
        quos magnam nam? Perspiciatis, ipsam maxime error aliquam expedita
        voluptatem architecto, tenetur ipsa eum facilis quisquam atque velit.
        Perferendis id ex quaerat optio, unde alias repudiandae enim quia
        molestiae adipisci commodi quidem harum animi ipsam sunt maiores.
        Molestias, accusantium odio! Voluptas laboriosam neque quasi iste,
        necessitatibus doloribus provident magni vitae reiciendis totam libero
        ad nihil animi illo fuga cumque, odio iure quod repudiandae nisi. Ipsum
        cumque aliquid, incidunt esse magni hic fugit facilis neque soluta
        facere ipsa, voluptas quo! Modi ea animi earum in nam porro neque eius
        veritatis. Sed, velit esse veniam incidunt voluptates ut, perferendis
        recusandae sunt reprehenderit aliquid nihil quasi, possimus at. Error
        rem non cupiditate? Accusamus ipsum fugit incidunt dolores, iure at,
        minus assumenda voluptatibus ratione ea laboriosam fuga ipsam
        perspiciatis magnam quia quaerat eligendi. Aliquam rem iusto sequi qui a
        blanditiis, odio ipsum necessitatibus exercitationem, consequatur
        officiis autem? Officia, dignissimos numquam. Iusto inventore aperiam
        nam. Provident ullam deserunt, aperiam et itaque consectetur illo rerum
        saepe minus quisquam voluptate repudiandae esse ratione ipsum possimus
        vero porro minima eaque! Fugit odit officiis fuga quidem nam voluptatum
        atque, nemo molestiae ad temporibus reiciendis, incidunt sint rerum quae
        error, explicabo doloribus facere. Sunt modi exercitationem porro est
        commodi ex, aspernatur iusto. Nulla corrupti reiciendis earum aperiam,
        magni, odit facere et maxime culpa maiores possimus deleniti cupiditate
        cumque molestiae sint, eaque rem sunt modi sequi quo doloribus?
        Recusandae velit aliquam provident vitae. Alias eveniet esse blanditiis
        maiores molestias minus? Fugit, mollitia, ullam voluptatum eum nemo,
        harum reiciendis error sint nisi eaque officiis maiores aliquid ipsa
        quod ratione! Aliquid ab nesciunt quia reprehenderit neque voluptatem
        velit incidunt cum non nihil explicabo, tempora iusto qui quis error
        alias assumenda sint amet dolor! Enim exercitationem tenetur quae
        provident sed aperiam sequi hic inventore voluptatem corrupti,
        cupiditate similique aspernatur ad? Magni doloribus dolores tenetur
        ipsam mollitia minus necessitatibus, vitae debitis voluptatem omnis
        libero optio culpa ullam repellendus nulla odio? Commodi eligendi quos
        nobis sed magni debitis eveniet veniam illo amet quo officia libero
        alias, ipsum velit provident ea? Ab minus mollitia, numquam quos
        impedit, tempora voluptates ducimus illo blanditiis esse est porro ex
        dolores minima maiores perferendis, excepturi explicabo sapiente nulla?
        Molestias modi nisi atque minima? Iste illo, numquam dolores
        perferendis, voluptatum nobis nihil nostrum totam doloremque incidunt
        consectetur ad. Totam, provident earum reprehenderit quidem rerum sit
        assumenda eius expedita voluptates sint, illo ad, ducimus quia? Ipsum
        quam quasi nisi dolore? Omnis sapiente eum et voluptatem fugiat
        consequatur quaerat excepturi, tempora asperiores recusandae doloribus
        sequi molestias aspernatur laudantium tenetur eius totam quidem veniam.
        Deserunt quasi inventore laudantium, pariatur laborum est culpa atque,
        dignissimos ipsa praesentium harum, in amet! Vel saepe voluptate
        reprehenderit, blanditiis repellendus, architecto enim repudiandae eius
        nobis omnis eos dolor culpa animi porro odit rerum? Libero magnam
        repudiandae harum numquam quo. Fuga voluptatum natus magnam! Asperiores
        officia explicabo dolores consectetur! Sit, iusto accusantium quia illo
        nemo at? Quam quasi esse magnam. Deleniti a quis nulla corporis dolor
        autem aliquid esse debitis ipsam. Odio cumque, animi nulla incidunt
        maxime sed neque facere officia fugit quae suscipit sapiente
        consectetur, porro vel nobis nulla sint doloribus qui quas odio debitis
        nisi libero? Cupiditate iure voluptatem distinctio similique, ut aliquid
        sequi nesciunt! Eum sint tempora perspiciatis quaerat explicabo cum
        praesentium consectetur nihil vel harum cumque quae, repellat eius
        beatae incidunt temporibus tempore nesciunt perferendis assumenda sequi.
        Similique nisi odio, adipisci ad possimus sequi cumque labore! Aliquid,
        dolorum consectetur nisi sapiente quo incidunt libero quaerat eos
        placeat dolorem facilis libero!
      </p>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: true,
      stations: [],
      from: "",
      to: "",
      doj: "",
      errors: {},
    };
  },
  // mounted() {
  //   this.getStations();
  // },
  methods: {
    getStations() {
      axios.get("/list-stations").then((res) => {
        this.stations = res.data;
        this.loading = false;
        // console.log(this.stations);
      });
    },
  },
};
</script>
<style>
.money-partners .money-logo img {
  height: 25px;
  margin-left: 5px;
}
</style>