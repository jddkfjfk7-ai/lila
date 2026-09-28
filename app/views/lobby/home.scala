package views.lobby

import play.api.libs.json.Json

import lila.app.UiEnv.{ *, given }
import lila.app.mashup.Preload.Homepage
import lila.core.perf.UserWithPerfs

object home:

  def apply(homepage: Homepage)(using ctx: Context) =
    import homepage.*
    val donateLink =
      a(cls := "lobby__support-link", href := routes.Plan.index())(
        iconTag(patronIconChar),
        span(cls := "lobby__support-link__text")(
          strong(trans.patron.donate()),
          span(trans.patron.becomePatron())
        )
      )
    val swagLink =
      a(cls := "lobby__support-link", href := "/swag")(
        iconTag(Icon.Tshirt),
        span(cls := "lobby__support-link__text")(
          strong("Swag Store"),
          span(trans.site.playChessInStyle())
        )
      )
    Page("")
      .copy(fullTitle = "Kero Chess • Play, train, watch and improve".some)
      .i18n(_.variant)
      .js(
        PageModule(
          "lobby",
          Json
            .obj(
              "data" -> data,
              "showRatings" -> ctx.pref.showRatings
            )
            .add("hasUnreadLichessMessage", hasUnreadLichessMessage)
            .add("bots", Granter.opt(_.Beta))
            .add("playban", playban.map(lila.playban.TempBan.lobbyJson))
        )
      )
      .css("lobby")
      .graph(
        OpenGraph(
          image = s"$netBaseUrl/brand/kero-mark.svg".some,
          title = "Kero Chess",
          url = netBaseUrl.into(Url),
          description = "Play chess, train with purpose, analyze deeply and compete with players around the world."
        )
      )
      .hrefLangs(lila.ui.LangPath("/")):
        given Option[UserWithPerfs] = homepage.me
        main(
          cls := List(
            "lobby" -> true,
            "lobby--platform" -> true,
            "lobby-nope" -> (playban.isDefined || currentGame.isDefined || homepage.hasUnreadLichessMessage)
          )
        )(
          div(cls := "lobby__side")(
            ctx.blind.option(h2(trans.nvui.featuredEvents())),
            ctx.kid.no.option(views.streamer.bits.liveStreams(streams)),
            div(cls := "lobby__spotlights"):
              val eventTags = events.map(bits.spotlight)
              val relayTags = views.relay.ui.spotlight(relays)
              frag(
                eventTags,
                relayTags,
                ctx.noBot.option {
                  val nbManual = eventTags.size + relayTags.size
                  val simulBBB = simuls.find(isFeaturable(_) && nbManual < 4)
                  val nbForced = nbManual + simulBBB.size.toInt
                  val tourBBBs = if nbForced > 3 then 0 else if nbForced == 3 then 1 else 3 - nbForced
                  frag(
                    lila.tournament.Spotlight.select(tours, tourBBBs).map {
                      views.tournament.list.homepageSpotlight(_)
                    },
                    swiss.ifTrue(nbForced < 3).map(views.swiss.ui.homepageSpotlight),
                    simulBBB.map(views.simul.ui.homepageSpotlight)
                  )
                }
              )
            ,
            classes.nonEmpty.option:
              div(cls := "lobby__classes"):
                classes.map: clas =>
                  a(href := routes.Clas.show(clas.id), dataIcon := Icon.Group)(clas.name)
            ,
            if ctx.isAuth then
              div(cls := "lobby__timeline")(
                ctx.blind.option(h2(trans.site.timeline())),
                views.timeline.entries(userTimeline)
              )
            else
              div(cls := "about-side")(
                ctx.blind.option(h2(trans.site.about())),
                trans.site.xIsAFreeYLibreOpenSourceChessServer(
                  "Kero Chess",
                  a(cls := "blue", href := routes.Plan.features)(trans.site.really.txt())
                ),
                " ",
                a(href := "/about")(trans.site.aboutX("Kero Chess"), "...")
              )
          ),
          currentGame
            .map(bits.currentGameInfo)
            .orElse:
              hasUnreadLichessMessage.option(bits.showUnreadLichessMessage)
            .orElse:
              playban.map(bits.playbanInfo)
            .getOrElse:
              if ctx.blind then blindLobby(blindGames) else bits.lobbyApp
          ,
          div(cls := "lobby__table")(
            div(cls := "lobby__start")(
              button(cls := "button button-metal lobby__start__button lobby__start__button--hook")(
                trans.site.createLobbyGame()
              ),
              button(cls := "button button-metal lobby__start__button lobby__start__button--friend")(
                trans.site.challengeAFriend()
              ),
              button(cls := "button button-metal lobby__start__button lobby__start__button--ai")(
                trans.site.playAgainstComputer()
              )
            )
          ),
          div(cls := "lobby__bots")(
            div(cls := "lobby__bots__header")(
              div(
                h2("Play Kero Bots"),
                span("Real AI games • casual • choose your engine level")
              ),
              a(href := "/?level=1#ai")("Open setup")
            ),
            div(cls := "lobby__bots__grid")(
              List(
                (1, "Warm-up", "Learn the basics"),
                (2, "Beginner", "Build confidence"),
                (3, "Developing", "Practice clean play"),
                (4, "Club", "Challenge your habits"),
                (5, "Advanced", "Test your calculation"),
                (6, "Expert", "Demand accuracy"),
                (7, "Master", "Serious resistance"),
                (8, "Elite", "Highest built-in level")
              ).map { case (level, name, description) =>
                a(cls := "lobby__bot", href := s"/?level=$level#ai")(
                  span(cls := "lobby__bot__level")(s"AI $level"),
                  strong(name),
                  span(cls := "lobby__bot__description")(description),
                  span(cls := "lobby__bot__meta")("Unrated game")
                )
              }
            )
          ),
          div(cls := "lobby__platform")(
            div(cls := "lobby__platform__header")(
              div(
                h2("Kero Chess"),
                span("One connected chess platform for play, improvement, competition and community.")
              ),
              a(cls := "lobby__platform__all", href := "/faq")("Explore the platform")
            ),
            nav(cls := "lobby__platform__nav", aria.label := "Kero Chess platform")(
              a(href := "/")(strong("Play"), span("Rated, casual & custom games")),
              a(href := "/training")(strong("Train"), span("Puzzles & daily practice")),
              a(href := "/tutor")(strong("Coach"), span("Personal game insights")),
              a(href := "/analysis")(strong("Analyze"), span("Deep positions & variations")),
              a(href := "/opening")(strong("Openings"), span("Explore opening trees")),
              a(href := "/study")(strong("Studies"), span("Build & share repertoires")),
              a(href := "/tournament")(strong("Arena"), span("Live tournaments")),
              a(href := "/swiss")(strong("Swiss"), span("Competitive pairings")),
              a(href := "/simul")(strong("Simuls"), span("Play many boards")),
              a(href := "/storm")(strong("Storm"), span("Fast tactical training")),
              a(href := "/racer")(strong("Racer"), span("Race your tactics")),
              a(href := "/player")(strong("Community"), span("Players, teams & friends"))
            )
          ),
          div(cls := "lobby__support")(donateLink, swagLink),
          div(cls := "lobby__tv")(
            donateLink,
            featured.map(g => views.game.mini(Pov.naturalOrientation(g), tv = true))
          ),
          div(cls := "lobby__puzzle")(
            swagLink,
            puzzle.map(p => views.puzzle.bits.dailyLink(p)())
          ),
          views.ublog.ui.homeCarousel(ublogPosts),
          div(cls := "lobby__feed"):
            views.feed.lobbyUpdates(lastUpdates)
          ,
          ctx.noBot.option(bits.underboards(tours, simuls)),
          div(cls := "lobby__about")(
            ctx.blind.option(h2(trans.site.about())),
            a(href := "/about")(trans.site.aboutX("Kero Chess")),
            a(href := "/faq")(trans.faq.faqAbbreviation()),
            a(href := "/contact")(trans.contact.contact()),
            a(href := "/app")(trans.site.mobileApp()),
            a(href := routes.Cms.tos)(trans.site.termsOfService()),
            a(href := "/privacy")(trans.site.privacy()),
            a(href := "/source")(trans.site.sourceCode()),
            a(href := "/ads")("Ads"),
            views.bits.connectLinks
          )
        )
