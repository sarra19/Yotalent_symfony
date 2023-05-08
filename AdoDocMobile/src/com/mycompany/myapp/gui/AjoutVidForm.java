package com.mycompany.myapp.gui;

import com.codename1.components.InfiniteProgress;
import com.codename1.ui.Button;
import com.codename1.ui.Dialog;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.entities.Video;
import com.mycompany.myapp.services.VideoService;

public class AjoutVidForm extends BaseForm {
    private Form current;

    public AjoutVidForm(Resources res, Form previous) {
        setTitle("Add Video");
        super.addSideMenu(res);
        current = this;
        getContentPane().setScrollVisible(false);

        TextField titre = new TextField("", "nomVid");
        titre.setUIID("TextFieldBlack");

        Button chooseFileButton = new Button("Choose file");
TextField selectedFileField = new TextField("", "Selected file:", 20, TextField.UNEDITABLE);
        selectedFileField.setUIID("TextFieldBlack");
        chooseFileButton.addActionListener((e) -> {
            com.codename1.ui.Display.getInstance().openGallery(new ActionListener() {
                @Override
                public void actionPerformed(ActionEvent evt) {
                    String selectedFile = (String) evt.getSource();
                    selectedFileField.setText(selectedFile);
                }
            }, com.codename1.ui.Display.GALLERY_VIDEO);
        });

        TextField titre2 = new TextField("", "idEST");
        titre2.setUIID("TextFieldBlack");

        Button btnAjouter = new Button("Add");
        btnAjouter.addActionListener((e) -> {
            try {
                if (titre.getText().isEmpty() || selectedFileField.getText().isEmpty() || titre2.getText().isEmpty()) {
                    Dialog.show("Veuillez vérifier les données", "", "Annuler", "OK");
                } else if (titre.getText().length() < 5 || selectedFileField.getText().length() < 5) {
                    Dialog.show("Veuillez vérifier les données", "Entrez au moins 5 caractères.", "OK", null);
                } else {
                    InfiniteProgress ip = new InfiniteProgress();
                    final Dialog iDialog = ip.showInfiniteBlocking();
                    String nom = titre.getText();
                    String url = selectedFileField.getText();
                    int idest = Integer.parseInt(titre2.getText());

                    Video p = new Video(nom, url, idest);
                    System.out.println("data Auto == " + p);
                    VideoService.getInstance().AjoutVideo(p);
                    iDialog.dispose();

                    new ListVidForm(res).show();

                    refreshTheme();
                }
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });

        this.add(titre);
        this.add(chooseFileButton);
        this.add(selectedFileField);
        this.add(titre2);
        this.add(btnAjouter);

        Button back = new Button("Cancel");
        back.addActionListener(l -> {
            previous.show();
        });
        this.add(back);
    }
}
