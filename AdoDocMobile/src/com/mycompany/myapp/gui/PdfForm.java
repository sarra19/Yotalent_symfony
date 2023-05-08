package com.mycompany.myapp.gui;

import com.codename1.io.FileSystemStorage;
import com.codename1.io.Util;
import com.codename1.ui.Button;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;

import java.io.IOException;

public class PdfForm extends Form {
     Form current;
    public PdfForm(Resources res, Form previous) throws IOException {
        super("PDF Viewer", BoxLayout.y());
        
        Button devGuide = new Button("Download PDF");
        devGuide.addActionListener(e -> {
            FileSystemStorage fs = FileSystemStorage.getInstance();
            String fileName = fs.getAppHomePath() + "seats.pdf";
            if(!fs.exists(fileName)) {
                Util.downloadUrlToFile("http://localhost:8000/espace/pdfs", fileName, true);
            }
            Display.getInstance().execute(fileName);
        });
        
        add(devGuide);
        show();
    }
}