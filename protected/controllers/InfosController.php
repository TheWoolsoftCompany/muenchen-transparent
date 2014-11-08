<?php

class InfosController extends RISBaseController
{
	public function actionSoFunktioniertStadtpolitik()
	{
		$this->top_menu = "so_funktioniert";
		$this->render('so_funktioniert_stadtpolitik');
	}

	public function actionImpressum()
	{
		$this->top_menu = "impressum";
		$this->render('impressum');
	}

	public function actionDatenschutz()
	{
		$this->top_menu = "datenschutz";
		$this->render('datenschutz');
	}

	public function actionAPI()
	{
		$this->top_menu = "api";
		$this->render('api');
	}

	public function actionUeber()
	{
		$this->top_menu = "";

		$this->render('ueber', array());
	}


	public function actionFeedback()
	{
		$this->top_menu = "";

		if (AntiXSS::isTokenSet("send")) {
			$fp = fopen(EMAIL_LOG_FILE . "." . date("YmdHis"), "a");
			fwrite($fp, date("Y-m-d H:i:s") . "\n");
			fwrite($fp, print_r($_REQUEST, true));
			fclose($fp);

			$text = "Antwort erwünscht: " . (isset($_REQUEST["answer_wanted"]) ? "Ja" : "Nein") . "\n";
			$text .= "E-Mail: " . $_REQUEST["email"] . "\n";
			$text .= "\n\n";
			$text .= $_REQUEST["message"];

			RISTools::send_email(Yii::app()->params['adminEmail'], "[München Transparent] Feedback", $text, null, "feedback");

			$this->render('feedback_done', array());
		} else {
			$this->render('feedback_form', array(
				"current_url" => Yii::app()->createUrl("infos/feedback"),
				"msg_err"     => "",
			));
		}
	}

	public function actionGlossar()
	{
		$this->top_menu = "so_funktioniert";

		if (AntiXSS::isTokenSet("anlegen") && $this->binContentAdmin()) {
			$text                     = new Text();
			$text->typ                = Text::$TYP_GLOSSAR;
			$text->titel              = $_REQUEST["titel"];
			$text->text               = $_REQUEST["text"];
			$text->pos                = 0;
			$text->edit_datum         = new CDbExpression("NOW()");
			$text->edit_benutzerIn_id = $this->aktuelleBenutzerIn()->id;
			$text->save();
		}

		$eintraege = Text::model()->findAllByAttributes(array(
			"typ" => Text::$TYP_GLOSSAR,
		), array("order" => "titel"));

		$this->render('glossar', array(
			"eintraege" => $eintraege,
		));
	}


	public function actionGlossarBearbeiten($id)
	{
		if (!$this->binContentAdmin()) throw new Exception("Kein Zugriff");

		$this->top_menu = "so_funktioniert";

		/** @var Text $eintrag */
		$eintrag = Text::model()->findByAttributes(array(
			"id"  => $id,
			"typ" => Text::$TYP_GLOSSAR,
		));
		if (!$eintrag) throw new Exception("Nicht gefunden");

		if (AntiXSS::isTokenSet("speichern")) {
			$eintrag->titel              = $_REQUEST["titel"];
			$eintrag->text               = $_REQUEST["text"];
			$eintrag->edit_datum         = new CDbExpression("NOW()");
			$eintrag->edit_benutzerIn_id = $this->aktuelleBenutzerIn()->id;
			$eintrag->save();

			$this->redirect($this->createUrl("infos/glossar"));
		}

		if (AntiXSS::isTokenSet("del")) {
			$eintrag->delete();
			$this->redirect($this->createUrl("infos/glossar"));
		}

		$this->render('glossar_bearbeiten', array(
			"eintrag" => $eintrag,
		));
	}
}