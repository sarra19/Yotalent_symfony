/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tn.esprit.YoTalent.GUI;
import tn.esprit.YoTalent.GUI.Mail;
import tray.notification.TrayNotification;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Label;
import javafx.scene.control.TableView;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyEvent;
import javafx.scene.input.MouseEvent;
import javafx.stage.Stage;

import tn.esprit.YoTalent.entities.Categorie;
import tn.esprit.YoTalent.entities.Contrat;
import tn.esprit.YoTalent.entities.EspaceTalent;
import tn.esprit.YoTalent.entities.User;
import tn.esprit.YoTalent.entities.Video;
import tn.esprit.YoTalent.services.ServiceET;
import tn.esprit.YoTalent.utils.MaConnexion;
import tray.animations.AnimationType;
import tray.notification.NotificationType;

import com.itextpdf.text.Chunk;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.pdf.PdfWriter;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;

/**
 * FXML Controller class
 *
 * @author sarra
 */
public class interfESTController implements Initializable {
    
    @FXML
    private TableView<EspaceTalent> AfficherC;
    ServiceET es=new ServiceET();
    // EspaceTalent e = new EspaceTalent();
 ObservableList<EspaceTalent> espaceTalent ;
      private boolean isLightMode =true;
    @FXML
    private Button ExitCat;
      @FXML
    private ComboBox<String> combo_comment;
    @FXML
    private TextField IdT;
    @FXML
    private TextField TitreT;
    @FXML
    private Button ModifyT;
  @FXML
    private TextField Recherche;
    @FXML
    private TableColumn<EspaceTalent, Integer> colIdEST;
    @FXML
    private TableColumn<EspaceTalent, String> colTitre;
    @FXML
    private TableColumn<EspaceTalent, User> colIdU;
    @FXML
    private TableColumn<EspaceTalent, Video> colIdVid;
    @FXML
    private TableColumn<EspaceTalent, Categorie> colIdCat;
    @FXML
    private TableColumn<EspaceTalent, Contrat> colIdC;
    @FXML
    private TextField DeleteT;
    @FXML
    private ImageView NextCat;
    @FXML
    private Button AddT;
    @FXML
    private ImageView PrevCat;
    @FXML
    private TextField IdVidT;
    @FXML
    private TextField IdCatT;
    @FXML
    private TextField IdCT;
    @FXML
    private TextField IdUT;
    @FXML
    private Button dd;
     private Connection cnx;
    public static EspaceTalent selectedEvent = null;
    @FXML
    private Button TriTitre;

    @FXML
    private TextField textFieldIdEST;

    @FXML
    private ComboBox<User> comboU;
     @FXML
    private ComboBox<Video> comboV;
      @FXML
    private ComboBox<Categorie> comboCat;
      @FXML
    private ComboBox<Contrat> comboC;



    public interfESTController(){
        cnx = MaConnexion.getInstance().getCnx();
        
    }

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
       
       
          AfficherC.setFocusTraversable(false);
        try {
            getEvents();
        } catch (SQLException ex) {
            Logger.getLogger(interfESTController.class.getName()).log(Level.SEVERE, null, ex);
        }
          comboU.setItems(RecupCombo());
          comboV.setItems(RecupComboV());
           comboCat.setItems(RecupComboCat());
              comboC.setItems(RecupComboC());
    } 
   
    
   

@FXML
private void Modify_Button(ActionEvent event) throws SQLException {
String titre;
     int idValue = Integer.parseInt(IdT.getText()); 
         if ((TitreT.getText().length()==0))
                { Alert alert = new Alert(Alert.AlertType.ERROR);
                   alert.setTitle("Error ");
                    alert.setHeaderText("Error!");
                    alert.setContentText("Fields cannot be empty");
                    alert.showAndWait();}
         
     
         else{
  try{
            titre = String.valueOf(TitreT.getText());
           
        }catch(Exception exc){
            System.out.println("name exception");
            return;
        }  
          
EspaceTalent espacetalent = AfficherC.getSelectionModel().getSelectedItem();
if (espacetalent == null) {
    Alert alert = new Alert(AlertType.ERROR);
    alert.setTitle("Error");
    alert.setHeaderText("No EspaceTalent selected");
    alert.setContentText("Please select an EspaceTalent to update.");
    alert.showAndWait();
    return;
}

  EspaceTalent Ps=new EspaceTalent(idValue,TitreT.getText(),comboU.getValue(),comboV.getValue(),comboCat.getValue(),comboC.getValue());

   
           
es.updateOne(Ps);
getEvents();

Alert alert = new Alert(AlertType.INFORMATION);
alert.setTitle("Information");
alert.setHeaderText("EspaceTalent updated");
alert.setContentText("EspaceTalent updated successfully!");
alert.showAndWait();

} }








    @FXML
    private void ddbtn(ActionEvent event) throws SQLException {
        
      
         
         
         EspaceTalent e1 = AfficherC.getItems().get(AfficherC.getSelectionModel().getSelectedIndex());
      
        try {
            es.deletOne(e1);
        } catch (SQLException ex) {
            Logger.getLogger(interfESTController.class.getName()).log(Level.SEVERE, null, ex);
        }
         Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent delete");
            alert.setContentText("EspaceTalent deleted successfully!");
            alert.showAndWait();
         getEvents();
       
        
    }
    
    
    
    
    public void getEvents() throws SQLException {
     
       
       
   colIdEST.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idEST"));
     
   colTitre.setCellValueFactory(new PropertyValueFactory<EspaceTalent,String>("titre"));
colIdU.setCellValueFactory(new PropertyValueFactory<EspaceTalent, User>("idU"));
colIdVid.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Video>("idVid"));
colIdCat.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Categorie>("idCat"));
colIdC.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Contrat>("idC"));
    
    ServiceET es=new ServiceET();
       espaceTalent= es.FetchEST();
        System.out.println(espaceTalent);
        AfficherC.setItems(espaceTalent); 
    } 
  
   
    
    
@FXML
private void AddCat_Button(ActionEvent event) throws SQLException {
      String titre;
     
         if ((TitreT.getText().length()==0))
                { Alert alert = new Alert(Alert.AlertType.ERROR);
                   alert.setTitle("Error ");
                    alert.setHeaderText("Error!");
                    alert.setContentText("Fields cannot be empty");
                    alert.showAndWait();}
         
     
         else{
             
//           try{
//            titre = String.valueOf(TitreT.getText());
//           
//        }catch(Exception exc){
//            System.out.println("name exception");
//            return;
//        }  
          
         
         
          try{
         
            EspaceTalent Ps=new EspaceTalent(TitreT.getText(),comboU.getValue(),comboV.getValue(),comboCat.getValue(),comboC.getValue());

   
            





         es.createOne(Ps);
         getEvents();
       
          FXMLLoader loader = new FXMLLoader(getClass().getResource("DisplayEvents.fxml"));
          Alert alert = new Alert(Alert.AlertType.INFORMATION);
            alert.setTitle("Information ");
            alert.setHeaderText("EspaceTalent add");
            alert.setContentText("EspaceTalent added successfully!");
            alert.showAndWait();
            
             TrayNotification tray = new TrayNotification();
            tray.setTitle("Succés");
            tray.setMessage("espace ajouté avec succées !");
            tray.setAnimationType(AnimationType.POPUP);
            tray.setNotificationType(NotificationType.INFORMATION);
            tray.showAndWait();
          }catch(Exception exc){
               TrayNotification tray = new TrayNotification();
            tray.setTitle("echec");
            tray.setMessage("erreur ! vérifier votre saisi !");
            tray.setAnimationType(AnimationType.POPUP);
            tray.setNotificationType(NotificationType.INFORMATION);
            tray.showAndWait();
                return;
          }
         }
}


    public static ObservableList<User> RecupCombo() {
    ObservableList<User> list = FXCollections.observableArrayList();
    java.sql.Connection cnx = MaConnexion.getInstance().getCnx();
    String sql = "SELECT idU FROM user";
    
    try {
        PreparedStatement st = cnx.prepareStatement(sql);
        ResultSet R = st.executeQuery();
        
        while (R.next()) {
            int r = R.getInt(1);
            User user = new User(r);
            list.add(user);
        }
    } catch (SQLException ex) {
        ex.getMessage(); 
    } 
    return list;
}
    
     public static ObservableList<Video> RecupComboV() {
    ObservableList<Video> listV = FXCollections.observableArrayList();
    java.sql.Connection cnx = MaConnexion.getInstance().getCnx();
    String sql = "SELECT idVid FROM video";
    
    try {
        PreparedStatement st = cnx.prepareStatement(sql);
        ResultSet R = st.executeQuery();
        
        while (R.next()) {
            int r = R.getInt(1);
            Video video = new Video(r);
            listV.add(video);
        }
    } catch (SQLException ex) {
        ex.getMessage(); 
    } 
    return listV;
}

 public static ObservableList<Categorie> RecupComboCat() {
    ObservableList<Categorie> listV = FXCollections.observableArrayList();
    java.sql.Connection cnx = MaConnexion.getInstance().getCnx();
    String sql = "SELECT idCat FROM categorie";
    
    try {
        PreparedStatement st = cnx.prepareStatement(sql);
        ResultSet R = st.executeQuery();
        
        while (R.next()) {
            int r = R.getInt(1);
            Categorie categorie = new Categorie(r);
            listV.add(categorie);
        }
    } catch (SQLException ex) {
        ex.getMessage(); 
    } 
    return listV;
}
 public static ObservableList<Contrat> RecupComboC() {
    ObservableList<Contrat> listV = FXCollections.observableArrayList();
    java.sql.Connection cnx = MaConnexion.getInstance().getCnx();
    String sql = "SELECT idC FROM contrat";
    
    try {
        PreparedStatement st = cnx.prepareStatement(sql);
        ResultSet R = st.executeQuery();
        
        while (R.next()) {
            int r = R.getInt(1);
            Contrat contrat = new Contrat(r);
            listV.add(contrat);
        }
    } catch (SQLException ex) {
        ex.getMessage(); 
    } 
    return listV;
}

@FXML
private void handleArrowImageClick(MouseEvent event) throws IOException {
    Parent nextScene = FXMLLoader.load(getClass().getResource("InterfaceCategory.fxml"));
    Scene scene = new Scene(nextScene);
    Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
    stage.setScene(scene);
    stage.show();
}

@FXML
private void handleBackArrowImageClick(MouseEvent event) throws IOException {
    Parent previousScene = FXMLLoader.load(getClass().getResource("path/to/login.fxml"));
    Scene scene = new Scene(previousScene);
    Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
    stage.setScene(scene);
    stage.show();
}

@FXML
    void Recherche(KeyEvent event) throws SQLException {
  
       AfficherC.setItems(es.searchByEST(Recherche.getText()))  ;
    }

 @FXML
    void TriTitre(ActionEvent event) {
    
   colIdEST.setCellValueFactory(new PropertyValueFactory<EspaceTalent,Integer>("idEST"));
     
   colTitre.setCellValueFactory(new PropertyValueFactory<EspaceTalent,String>("titre"));
colIdU.setCellValueFactory(new PropertyValueFactory<EspaceTalent, User>("idU"));
colIdVid.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Video>("idVid"));
colIdCat.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Categorie>("idCat"));
colIdC.setCellValueFactory(new PropertyValueFactory<EspaceTalent, Contrat>("idC"));

  espaceTalent=es.getAllTriTitre();
             AfficherC.setItems(espaceTalent);
    }
     private void createPDF() throws DocumentException, FileNotFoundException {
        Document my_pdf_report = new Document();
        //String rand = String.valueOf(generate());
        String pdfName = "c:/pdf/Evenement.pdf";
        PdfWriter.getInstance(my_pdf_report, new FileOutputStream(pdfName));
        my_pdf_report.open();
        my_pdf_report.addTitle("hello");
        selectedEvent = AfficherC.getSelectionModel().getSelectedItem();
        String titre = selectedEvent.getTitre();
        my_pdf_report.add(new Chunk("vous avez participer a l'évenement " + titre));
        my_pdf_report.close();

        sendMail(pdfName);
    }
    
     public void sendMail(String pdfName) {

        Mail mail = new Mail();

        mail.setSubject("Module EspaceTalent");

        mail.setBody("Module EspaceTalent");

        mail.setReciever("sarra.benhamida@esprit.tn");

        mail.setFile(pdfName);
        MailService.doSend(mail);

    }
      @FXML
    private void onAjout(ActionEvent event) {
//        comment_service cs = new comment_service();
//        event_service ev = new event_service();
//        
//        
//        String nomEvent = combo_comment.getValue();
//        int id= ev.getidevent(nomEvent);  
//        String comment = text_comment.getText();
//        cs.create(comment,id);
//        combo_mod();
//        text_comment.clear();
//        combo_comment.setValue(null);
//        refresh();
    }
   
}