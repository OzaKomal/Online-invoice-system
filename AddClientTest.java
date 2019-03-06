package csuf.amse.ois;

import java.util.List;
import java.util.concurrent.TimeUnit;

import org.apache.log4j.Level;
import org.apache.log4j.Logger;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;
import org.junit.*;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxProfile;
import org.openqa.selenium.firefox.internal.ProfilesIni;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.Select;
import org.openqa.selenium.support.ui.WebDriverWait;

public class AddClientTest {
	private static org.apache.log4j.Logger log = Logger.getLogger(AddClientTest.class);
	
	private WebDriver driver;
	private WebDriverWait wait;
	private String baseUrl = "http://localhost:8080/online-invoicing-system";

	@Before
	public void setUp() throws Exception {
		log.setLevel(Level.INFO);
		
		System.out.println("Test Case Description: Adding a new client to the system \n" + "Author: Tawin\n");

		System.out.println("<Setup> \n" + "Setup WebDriver");

		// Fire fox
//		System.out.println("Testing on: Firefox");
//		ProfilesIni profile = new ProfilesIni();
//		FirefoxProfile myprofile = profile.getProfile("myProfile");
//		System.setProperty("webdriver.gecko.driver", "D:\\selenium workspace\\drivers\\geckodriver.exe");
//		driver = new FirefoxDriver(myprofile);

		// Chrome
		 System.out.println("Testing on: Chrome");
		 System.setProperty("webdriver.chrome.driver", "D:\\selenium workspace\\drivers\\chromedriver.exe");
		 DesiredCapabilities capabilities = DesiredCapabilities.chrome();
		 ChromeOptions options = new ChromeOptions();
		 options.addArguments("test-type");
		 options.addArguments("start-maximized");
		 options.addArguments("user-data-dir=D:/temp/");
		 capabilities.setCapability("chrome.binary","D:\\\\selenium workspace\\\\drivers\\\\chromedriver.exe");
		 capabilities.setCapability(ChromeOptions.CAPABILITY,options);
		 driver = new ChromeDriver(capabilities);
		 driver.manage().window().maximize();

		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);

		wait = new WebDriverWait(driver, 10);
	}

	@Test
	public void testAddClient() throws Exception {
		System.out.println("The steps of testing");

		System.out.println("\t1-Go to Online Invoicing System homepage");
		this.driver.get(baseUrl + "/index.php");
		assertEquals("Redirect to wrong page", baseUrl + "/index.php", driver.getCurrentUrl());

		System.out.println("\t2-Click on Clients button");
		driver.findElement(By.linkText("Clients")).click();
		assertEquals("Redirect to wrong page", baseUrl + "/clients_view.php", driver.getCurrentUrl());
		
		int prevCAmt = getTotalClients();

		System.out.println("\t3-Click on Add New button");
		driver.findElement(By.id("addNew")).click();
		assertEquals("ID is assigned already", driver.findElement(By.id("id")).getAttribute("innerHTML"), "");

		System.out.println("\t4-Enter Name");
		driver.findElement(By.id("name")).clear();
		driver.findElement(By.id("name")).sendKeys("David");

		System.out.println("\t5-Enter Contact");
		driver.findElement(By.id("contact")).clear();
		driver.findElement(By.id("contact")).sendKeys("+1 123 123 1234");

		System.out.println("\t6-Enter Title");
		driver.findElement(By.id("title")).clear();
		driver.findElement(By.id("title")).sendKeys("Mr.");

		System.out.println("\t7-Enter Address");
		driver.findElement(By.id("address")).clear();
		driver.findElement(By.id("address")).sendKeys("777 Seventh St.");

		System.out.println("\t8-Enter City");
		driver.findElement(By.id("city")).clear();
		driver.findElement(By.id("city")).sendKeys("LA");

		System.out.println("\t9-Pick Country");
		Select countryDropdown = new Select(driver.findElement(By.id("country")));
		countryDropdown.selectByValue("United States");

		System.out.println("\t10-Enter Phone");
		driver.findElement(By.id("phone")).clear();
		driver.findElement(By.id("phone")).sendKeys("+1 123 123 1234");

		System.out.println("\t11-Click on Email edit button");
		driver.findElement(By.id("email-edit-link")).sendKeys(Keys.ENTER);
		assertThat(driver.findElement(By.id("email")).getCssValue("display"), is(not("none")));
		
		System.out.println("\t12-Enter Email");
		driver.findElement(By.id("email")).clear();
		driver.findElement(By.id("email")).sendKeys("david@test.com");

		System.out.println("\t13-Click on Website edit button");
		driver.findElement(By.id("website-edit-link")).sendKeys(Keys.ENTER);
		assertThat(driver.findElement(By.id("website")).getCssValue("display"), is(not("none")));

		System.out.println("\t14-Enter Website");
		driver.findElement(By.id("website")).clear();
		driver.findElement(By.id("website")).sendKeys("www.david.test.com");

		System.out.println("\t15-Enter Comments");
		driver.findElement(By.xpath(".//*[@id='clients_dv_form']/fieldset/div[11]/div/div[2]/div")).clear();
		driver.findElement(By.xpath(".//*[@id='clients_dv_form']/fieldset/div[11]/div/div[2]/div")).sendKeys("No Comment");

		System.out.println("\t16-Click on Save New button");
		wait.until(ExpectedConditions.elementToBeClickable(By.id("insert")));
		driver.findElement(By.id("insert")).sendKeys(Keys.ENTER);

		System.out.println("\n17-Verify adding a new client result");
		
		System.out.println("\t17.1-Check returned message");
		WebElement messageDiv = driver.findElement(By.xpath("html/body/div[1]/div[3]"));
		List<WebElement> mDivChilds = messageDiv.findElements(By.xpath(".//*"));
		String returnMsg = mDivChilds.get(0).getAttribute("innerHTML");
		System.out.println("\t\tReturned Message:" + returnMsg);
		assertEquals("The new record has been saved successfully.", returnMsg);
		
		System.out.println("\t17.2-Check returned ID from database");
		System.out.println("\t\tReturned ID: " + driver.findElement(By.id("id")).getAttribute("innerHTML"));
		assertThat(driver.findElement(By.id("id")).getAttribute("innerHTML"), is(not("")));
		
		System.out.println("\t17.3-Go back and check total clients number");
		driver.findElement(By.id("deselect")).sendKeys(Keys.ENTER);
		int currentCAmt = getTotalClients();
		System.out.println("\t\tTotal clients: " + prevCAmt + "->" + currentCAmt);
		assertThat(currentCAmt, is(prevCAmt + 1));
	}

	@After
	public void tearDown() throws Exception {
		 driver.quit();
	}
	
	private int getTotalClients() {
		String[] navDetail = driver
				.findElement(By.xpath("html/body/div[1]/div[4]/div[1]/form/div[3]/div/div[1]/table/tfoot/tr/td"))
				.getAttribute("innerHTML").split(" ");
		return Integer.parseInt(navDetail[navDetail.length - 1]);
	}
}
